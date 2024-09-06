<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Karen;

class KarenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karens = Karen::orderBy('created_at', 'DESC')->get();
        return view('karen.index', compact('karens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('erwin.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Save the data using the daniel model
        $karen = new Karen;
        $karen->title = $request->input('title');
        $karen->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('karen'), $imageName);

            // Save the full path or URL of the image in the database
            $karen->image = 'karen/' . $imageName;
        }

        $karen->save();

        return redirect()->route('karen.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karen = Karen::findOrFail($id);
        return view('karen.show', compact('karen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karen = Karen::findOrFail($id);
        return view('daniel.edit', compact('karens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karen = Karen::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $karen->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('karen.index')->with('success', 'Karen updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karen = Karen::findOrFail($id);
        $karen->delete();

        return redirect()->route('karen.index')->with('success', 'Post deleted successfully');
    }
}

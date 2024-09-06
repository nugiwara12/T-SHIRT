<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Abel;

class AbelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abels = Abel::orderBy('created_at', 'DESC')->get();
        return view('abel.index', compact('abels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('abel.create');
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
        $abel = new Abel;
        $abel->title = $request->input('title');
        $abel->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('abel'), $imageName);

            // Save the full path or URL of the image in the database
            $abel->image = 'abel/' . $imageName;
        }

        $abel->save();

        return redirect()->route('abel.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $abel = Abel::findOrFail($id);
        return view('abel.show', compact('abel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $abel = Abel::findOrFail($id);
        return view('daniel.edit', compact('abels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $abel = Abel::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $abel->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('abel.index')->with('success', 'Abel updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $abel = Abel::findOrFail($id);
        $abel->delete();

        return redirect()->route('abel.index')->with('success', 'Post deleted successfully');
    }
}

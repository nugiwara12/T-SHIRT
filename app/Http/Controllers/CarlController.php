<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Carl;

class CarlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carls = Carl::orderBy('created_at', 'DESC')->get();
        return view('carl.index', compact('carls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('carl.create');
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
            return redirect()->route('carl.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Save the data using the daniel model
        $carl = new Carl;
        $carl->title = $request->input('title');
        $carl->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('carl'), $imageName);

            // Save the full path or URL of the image in the database
            $carl->image = 'carl/' . $imageName;
        }

        $carl->save();

        return redirect()->route('carl.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carl = Carl::findOrFail($id);
        return view('carl.show', compact('carl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $carl = Carl::findOrFail($id);
        return view('daniel.edit', compact('carls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $carl = Carl::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $carl->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('carl.index')->with('success', 'Carl updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carl = Carl::findOrFail($id);
        $carl->delete();

        return redirect()->route('carl.index')->with('success', 'Post deleted successfully');
    }
}

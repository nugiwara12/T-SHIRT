<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Daniel;

class DanielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daniels = Daniel::orderBy('created_at', 'DESC')->get();
        return view('daniel.index', compact('daniels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daniel.create');
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
            return redirect()->route('daniel.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Save the data using the daniel model
        $daniel = new Daniel;
        $daniel->title = $request->input('title');
        $daniel->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('daniel'), $imageName);

            // Save the full path or URL of the image in the database
            $daniel->image = 'daniel/' . $imageName;
        }

        $daniel->save();

        return redirect()->route('daniel.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $daniel = Daniel::findOrFail($id);
        return view('daniel.show', compact('daniel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $daniel = Daniel::findOrFail($id);
        return view('daniel.edit', compact('daniels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $daniel = Daniel::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $daniel->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('daniel.index')->with('success', 'Daniel updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $daniel = Daniel::findOrFail($id);
        $daniel->delete();

        return redirect()->route('daniel.index')->with('success', 'Post deleted successfully');
    }
}

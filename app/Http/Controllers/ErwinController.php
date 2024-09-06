<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Erwin;

class ErwinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $erwins = Erwin::orderBy('created_at', 'DESC')->get();
        return view('erwin.index', compact('erwins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('erwin.create');
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
        $erwin = new Erwin;
        $erwin->title = $request->input('title');
        $erwin->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('erwin'), $imageName);

            // Save the full path or URL of the image in the database
            $erwin->image = 'erwin/' . $imageName;
        }

        $erwin->save();

        return redirect()->route('erwin.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $erwin = Erwin::findOrFail($id);
        return view('erwin.show', compact('erwin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $erwin = Erwin::findOrFail($id);
        return view('daniel.edit', compact('erwins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $erwin = Erwin::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $erwin->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('erwin.index')->with('success', 'Erwin updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $erwin = Erwin::findOrFail($id);
        $erwin->delete();

        return redirect()->route('erwin.index')->with('success', 'Post deleted successfully');
    }
}

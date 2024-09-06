<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Christoper;

class ChristoperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $christopers = Christoper::orderBy('created_at', 'DESC')->get();
        return view('christoper.index', compact('christopers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('christoper.create');
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
            return redirect()->route('christoper.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Save the data using the Christoper model
        $christoper = new Christoper;
        $christoper->title = $request->input('title');
        $christoper->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('christoper'), $imageName);

            // Save the full path or URL of the image in the database
            $christoper->image = 'christoper/' . $imageName;
        }

        $christoper->save();

        return redirect()->route('christoper.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $christoper = Christoper::findOrFail($id);
        return view('christoper.show', compact('christoper'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $christoper = Christoper::findOrFail($id);
        return view('christoper.edit', compact('christoper'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $christoper = Christoper::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $christoper->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('christoper.index')->with('success', 'Christoper updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $christoper = Christoper::findOrFail($id);
        $christoper->delete();

        return redirect()->route('christoper.index')->with('success', 'Post deleted successfully');
    }
}

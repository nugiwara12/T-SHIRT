<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use App\Models\Brgtanod;

class BrgtanodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brgtanods = Brgtanod::all();
        $brgtanods = Brgtanod::orderBy('created_at', 'DESC')->get();

        return view('brgtanod.index', compact('brgtanods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brgtanods = Brgtanod::all();
        return view('brgtanod.create');
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
            return redirect()->route('brgtanod.create')
                ->withErrors($validator)
                ->withInput();
        }

            // Save the data using the Brgtanod model
            $brgtanod = new Brgtanod;
            $brgtanod->title = $request->input('title');
            $brgtanod->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            // Save the full path or URL of the image in the database
            $brgtanod->image = 'images/' . $imageName;
        }

        $brgtanod->save();

        return redirect()->route('brgtanod')->with('success', 'Record created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brgtanods = Brgtanod::findOrFail($id);

        return view('brgtanod.show', compact('brgtanods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brgtanods = Brgtanod::findOrFail($id);

        return view('brgtanod.edit', compact('brgtanods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->route('brgtanod.create')
            ->withErrors($validator)
            ->withInput();
    }

    return redirect()->route('brgtanod')->with('success', 'Record ' . ($request->has('id') ? 'updated' : 'created') . ' successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brgtanods = Brgtanod::findOrFail($id);

        $brgtanods->delete();

        return redirect()->route('brgtanod')->with('success', 'Post deleted successfully');
    }
}

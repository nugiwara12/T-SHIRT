<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Granada;

class GranadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $granadas = Granada::all();
        $granadas = Granada::orderBy('created_at', 'DESC')->get();

        return view('ggg.index', compact('granadas'));
    }

    public function glennDetail($id)
    {

        $granadas = Granada::find($id);
        return view('glennDetail', ['granadas' => $granadas]);
    }

    public function data3()
    {
        return view('ggg.index', [
            'granadas' => Granada::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $granadas = Granada::all();
        return view('ggg.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('granada.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $granada = new Granada;
        $granada->title = $request->input('title');
        $granada->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('kagawad3'), $imageName);
    
            // Save the full path or URL of the image in the database
            $granada->image = 'kagawad3/' . $imageName;
        }
    
        $granada->save();
    
        return redirect('/data3')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $granadas = Granada::findOrFail($id);

        return view('ggg.show', compact('granadas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit3(string $id)
    {
        $granadas = Granada::findOrFail($id);

        return view('ggg.edit', compact('granadas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update3(Request $request, $id)
{
    $granada = Granada::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($granada->image))) {
            File::delete(public_path($granada->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kagawad3'), $imageName);

        // Save the full path or URL of the image in the database
        $granada->image = 'kagawad3/' . $imageName;
    }

    // Update other fields
    $granada->title = $request->title;
    $granada->desc = $request->desc;
    $granada->save();

    return redirect('/data3')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete3($id)
    {
        $granada = Granada::find($id);

        Granada::whereId($id)->delete();

        return redirect('/data3')->with('success', 'data deleted succesful');

    }  
}

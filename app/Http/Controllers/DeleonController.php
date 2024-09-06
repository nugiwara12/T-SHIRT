<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Deleon;

class DeleonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deleons = Deleon::all();
        $deleons = Deleon::orderBy('created_at', 'DESC')->get();

        return view('deleon.index', compact('deleons'));
    }

    public function deleonDetail ($id)
    {

        $deleons = Deleon::find($id);
        return view('deleonDetail ', ['deleons' => $deleons]);
    }

    public function data10()
    {
        return view('deleon.index', [
            'deleon' => Deleon::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deleons = Deleon::all();
        return view('deleon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store10(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('deleon.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $deleon = new Deleon;
        $deleon->title = $request->input('title');
        $deleon->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Kapitan'), $imageName);
    
            // Save the full path or URL of the image in the database
            $deleon->image = 'Kapitan/' . $imageName;
        }
    
        $deleon->save();
    
        return redirect('/data10')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deleons = Deleon::findOrFail($id);

        return view('deleon.show', compact('deleons'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit10(string $id)
    {
        $deleons = Deleon::findOrFail($id);

        return view('deleon.edit', compact('deleons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update10(Request $request, $id)
{
    $deleon = Deleon::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($deleon->image))) {
            File::delete(public_path($deleon->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Kapitan'), $imageName);

        // Save the full path or URL of the image in the database
        $deleon->image = 'Kapitan/' . $imageName;
    }

    // Update other fields
    $deleon->title = $request->title;
    $deleon->desc = $request->desc;
    $deleon->save();

    return redirect('/data10')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete10($id)
    {
        $deleon = Deleon::find($id);

        Deleon::whereId($id)->delete();

        return redirect('/data10')->with('success', 'data deleted succesful');

    }  
}

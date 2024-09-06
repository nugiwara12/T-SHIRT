<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Manlapaz;

class ManlapazController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manlapazs = Manlapaz::all();
        $manlapazs = Manlapaz::orderBy('created_at', 'DESC')->get();

        return view('manlapaz.index', compact('manlapazs'));
    }

    public function abelleDetail ($id)
    {

        $manlapazs = Manlapaz::find($id);
        return view('abelleDetail ', ['manlapazs' => $manlapazs]);
    }

    public function data9()
    {
        return view('manlapaz.index', [
            'manlapaz' => Manlapaz::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manlapazs = Manlapaz::all();
        return view('manlapaz.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store9(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('manlapaz.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $manlapaz = new Manlapaz;
        $manlapaz->title = $request->input('title');
        $manlapaz->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Treasurer9'), $imageName);
    
            // Save the full path or URL of the image in the database
            $manlapaz->image = 'Treasurer9/' . $imageName;
        }
    
        $manlapaz->save();
    
        return redirect('/data9')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manlapazs = Manlapaz::findOrFail($id);

        return view('manlapaz.show', compact('manlapazs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit9(string $id)
    {
        $manlapazs = Manlapaz::findOrFail($id);

        return view('manlapaz.edit', compact('manlapazs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update9(Request $request, $id)
{
    $manlapaz = Manlapaz::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($manlapaz->image))) {
            File::delete(public_path($manlapaz->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Treasurer9'), $imageName);

        // Save the full path or URL of the image in the database
        $manlapaz->image = 'Treasurer9/' . $imageName;
    }

    // Update other fields
    $manlapaz->title = $request->title;
    $manlapaz->desc = $request->desc;
    $manlapaz->save();

    return redirect('/data9')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete9($id)
    {
        $manlapaz = Manlapaz::find($id);

        Manlapaz::whereId($id)->delete();

        return redirect('/data9')->with('success', 'data deleted succesful');

    }  
}

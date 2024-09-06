<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Adriano;

class AdrianoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adrianos = Adriano::all();
        $adrianos = Adriano::orderBy('created_at', 'DESC')->get();

        return view('adriano.index', compact('adrianos'));
    }

    public function adrianoDetail ($id)
    {

        $adrianos = Adriano::find($id);
        return view('adrianoDetail ', ['adrianos' => $adrianos]);
    }

    public function data8()
    {
        return view('adriano.index', [
            'adriano' => Adriano::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $adrianos = Adriano::all();
        return view('adriano.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store8(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('adriano.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $adriano = new Adriano;
        $adriano->title = $request->input('title');
        $adriano->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Sk-chairman'), $imageName);
    
            // Save the full path or URL of the image in the database
            $adriano->image = 'Sk-chairman/' . $imageName;
        }
    
        $adriano->save();
    
        return redirect('/data8')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $adrianos = Adriano::findOrFail($id);

        return view('adriano.show', compact('adrianos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit8(string $id)
    {
        $adrianos = Adriano::findOrFail($id);

        return view('adriano.edit', compact('adrianos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update8(Request $request, $id)
{
    $adriano = Adriano::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($adriano->image))) {
            File::delete(public_path($adriano->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Sk-chairman'), $imageName);

        // Save the full path or URL of the image in the database
        $adriano->image = 'Sk-chairman/' . $imageName;
    }

    // Update other fields
    $adriano->title = $request->title;
    $adriano->desc = $request->desc;
    $adriano->save();

    return redirect('/data8')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete8($id)
    {
        $adriano = Adriano::find($id);

        Adriano::whereId($id)->delete();

        return redirect('/data8')->with('success', 'data deleted succesful');

    }  
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Galang;

class GalangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galangs = Galang::all();
        $galangs = Galang::orderBy('created_at', 'DESC')->get();

        return view('galang.index', compact('galangs'));
    }

    public function galangDetail ($id)
    {

        $galangs = Galang::find($id);
        return view('galangDetail ', ['galangs' => $galangs]);
    }

    public function data11()
    {
        return view('galang.index', [
            'galang' => Galang::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galangs = Galang::all();
        return view('galang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store11(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('galang.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $galang = new Galang;
        $galang->title = $request->input('title');
        $galang->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Secretary'), $imageName);
    
            // Save the full path or URL of the image in the database
            $galang->image = 'Secretary/' . $imageName;
        }
    
        $galang->save();
    
        return redirect('/data11')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $galangs = Galang::findOrFail($id);

        return view('galang.show', compact('galangs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit11(string $id)
    {
        $galangs = Galang::findOrFail($id);

        return view('galang.edit', compact('galangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update11(Request $request, $id)
{
    $galang = Galang::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($galang->image))) {
            File::delete(public_path($galang->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Secretary'), $imageName);

        // Save the full path or URL of the image in the database
        $galang->image = 'Secretary/' . $imageName;
    }

    // Update other fields
    $galang->title = $request->title;
    $galang->desc = $request->desc;
    $galang->save();

    return redirect('/data11')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete11($id)
    {
        $galang = Galang::find($id);

        Galang::whereId($id)->delete();

        return redirect('/data11')->with('success', 'data deleted succesful');

    }  
}

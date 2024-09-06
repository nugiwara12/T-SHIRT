<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Arvhie;

class ArvhieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arvhies = Arvhie::all();
        $arvhies = Arvhie::orderBy('created_at', 'DESC')->get();

        return view('arvhie.index', compact('arvhies'));
    }

    public function arvhieDetail ($id)
    {

        $arvhies = Arvhie::find($id);
        return view('arvhieDetail ', ['arvhies' => $arvhies]);
    }

    public function data6()
    {
        return view('arvhie.index', [
            'arvhie' => Arvhie::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $arvhies = Arvhie::all();
        return view('arvhie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store6(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('arvhie.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $arvhie = new Arvhie;
        $arvhie->title = $request->input('title');
        $arvhie->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('kagawad6'), $imageName);
    
            // Save the full path or URL of the image in the database
            $arvhie->image = 'kagawad6/' . $imageName;
        }
    
        $arvhie->save();
    
        return redirect('/data6')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $arvhies = Arvhie::findOrFail($id);

        return view('arvhie.show', compact('arvhies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit6(string $id)
    {
        $arvhies = Arvhie::findOrFail($id);

        return view('arvhie.edit', compact('arvhies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update6(Request $request, $id)
{
    $arvhie = Arvhie::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($arvhie->image))) {
            File::delete(public_path($arvhie->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kagawad6'), $imageName);

        // Save the full path or URL of the image in the database
        $arvhie->image = 'kagawad6/' . $imageName;
    }

    // Update other fields
    $arvhie->title = $request->title;
    $arvhie->desc = $request->desc;
    $arvhie->save();

    return redirect('/data6')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete6($id)
    {
        $arvhie = Arvhie::find($id);

        Arvhie::whereId($id)->delete();

        return redirect('/data6')->with('success', 'data deleted succesful');

    }  
}

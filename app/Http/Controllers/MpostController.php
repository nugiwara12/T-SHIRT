<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Angelica;

class MpostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $angelicas = Angelica::all();
        $angelicas = Angelica::orderBy('created_at', 'DESC')->get();

        return view('angelica.index', compact('angelicas'));
    }

    public function MagsinoDetail($id)
    {

        $angelica = Angelica::find($id);
        return view('MagsinoDetail', ['angelica' => $angelica]);
    }

    public function data2()
    {
        return view('angelica.index', [
            'angelicas' => Angelica::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $angelicas = Angelica::all();
        return view('angelica.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('angelica.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the Angelica model
        $angelica = new Angelica;
        $angelica->title = $request->input('title');
        $angelica->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('kagawad1'), $imageName);
    
            // Save the full path or URL of the image in the database
            $angelica->image = 'kagawad1/' . $imageName;
        }
    
        $angelica->save();
    
        return redirect('/data2')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $angelicas = Angelica::findOrFail($id);

        return view('angelica.show', compact('angelicas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit2(string $id)
    {
        $angelicas = Angelica::findOrFail($id);

        return view('angelica.edit', compact('angelicas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update2(Request $request, $id)
{
    $angelica = Angelica::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($angelica->image))) {
            File::delete(public_path($angelica->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kagawad1'), $imageName);

        // Save the full path or URL of the image in the database
        $angelica->image = 'kagawad1/' . $imageName;
    }

    // Update other fields
    $angelica->title = $request->title;
    $angelica->desc = $request->desc;
    $angelica->save();

    return redirect('/data2')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete2($id)
    {
        $sample = Angelica::find($id);

        Angelica::whereId($id)->delete();

        return redirect('/data2')->with('success', 'data deleted succesful');

    }  
}

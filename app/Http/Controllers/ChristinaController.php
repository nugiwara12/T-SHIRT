<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Christina;

class ChristinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $christinas = Christina::all();
        $christinas = Christina::orderBy('created_at', 'DESC')->get();

        return view('Christina.index', compact('christinas'));
    }

    public function christinaDetail ($id)
    {

        $christina = Christina::find($id);
        return view('christinaDetail ', ['christina' => $christina]);
    }

    public function data5()
    {
        return view('Christina.index', [
            'christina' => Christina::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $christinas = Christina::all();
        return view('Christina.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store5(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('Christina.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $christina = new Christina;
        $christina->title = $request->input('title');
        $christina->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('kagawad5'), $imageName);
    
            // Save the full path or URL of the image in the database
            $christina->image = 'kagawad5/' . $imageName;
        }
    
        $christina->save();
    
        return redirect('/data5')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $christinas = Christina::findOrFail($id);

        return view('Christina.show', compact('christinas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit5(string $id)
    {
        $christinas = Christina::findOrFail($id);

        return view('Christina.edit', compact('christinas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update5(Request $request, $id)
{
    $christina = Christina::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($christina->image))) {
            File::delete(public_path($christina->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kagawad5'), $imageName);

        // Save the full path or URL of the image in the database
        $christina->image = 'kagawad5/' . $imageName;
    }

    // Update other fields
    $christina->title = $request->title;
    $christina->desc = $request->desc;
    $christina->save();

    return redirect('/data5')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete5($id)
    {
        $christina = Christina::find($id);

        Christina::whereId($id)->delete();

        return redirect('/data5')->with('success', 'data deleted succesful');

    }  
}

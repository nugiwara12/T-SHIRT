<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Macabanti;

class MacabantiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $macabantis = Macabanti::all();
        $macabantis = Macabanti::orderBy('created_at', 'DESC')->get();

        return view('macabanti.index', compact('macabantis'));
    }

    public function macabantiDetail ($id)
    {

        $macabantis = Macabanti::find($id);
        return view('macabantiDetail ', ['macabantis' => $macabantis]);
    }

    public function data7()
    {
        return view('macabanti.index', [
            'macabanti' => Macabanti::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $macabantis = Macabanti::all();
        return view('macabanti.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store7(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('macabanti.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $macabanti = new Macabanti;
        $macabanti->title = $request->input('title');
        $macabanti->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('kagawad7'), $imageName);
    
            // Save the full path or URL of the image in the database
            $macabanti->image = 'kagawad7/' . $imageName;
        }
    
        $macabanti->save();
    
        return redirect('/data7')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $macabantis = Macabanti::findOrFail($id);

        return view('macabanti.show', compact('macabantis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit7(string $id)
    {
        $macabantis = Macabanti::findOrFail($id);

        return view('macabanti.edit', compact('macabantis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update7(Request $request, $id)
{
    $macabanti = Macabanti::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($macabanti->image))) {
            File::delete(public_path($macabanti->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kagawad7'), $imageName);

        // Save the full path or URL of the image in the database
        $macabanti->image = 'kagawad7/' . $imageName;
    }

    // Update other fields
    $macabanti->title = $request->title;
    $macabanti->desc = $request->desc;
    $macabanti->save();

    return redirect('/data7')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete7($id)
    {
        $macabanti = Macabanti::find($id);

        Macabanti::whereId($id)->delete();

        return redirect('/data7')->with('success', 'data deleted succesful');

    }  
}

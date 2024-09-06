<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Growen;

class DanielAgustinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $growens = Growen::all();
        $growens = Growen::orderBy('created_at', 'DESC')->get();

        return view('danielAgustin.index', compact('growens'));
    }

    public function agustinDetail($id)
    {

        $growen = Growen::find($id);
        return view('agustinDetail', ['growen' => $growen]);
    }

    public function data4()
    {
        return view('danielAgustin.index', [
            'growens' => Growen::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $growens = Growen::all();
        return view('danielAgustin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store4(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('growen.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $growen = new Growen;
        $growen->title = $request->input('title');
        $growen->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('kagawad4'), $imageName);
    
            // Save the full path or URL of the image in the database
            $growen->image = 'kagawad4/' . $imageName;
        }
    
        $growen->save();
    
        return redirect('/data4')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $growens = Growen::findOrFail($id);

        return view('danielAgustin.show', compact('growens'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit4(string $id)
    {
        $growens = Growen::findOrFail($id);

        return view('danielAgustin.edit', compact('growens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update4(Request $request, $id)
{
    $growen = Growen::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($growen->image))) {
            File::delete(public_path($growen->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kagawad4'), $imageName);

        // Save the full path or URL of the image in the database
        $growen->image = 'kagawad4/' . $imageName;
    }

    // Update other fields
    $growen->title = $request->title;
    $growen->desc = $request->desc;
    $growen->save();

    return redirect('/data4')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete4($id)
    {
        $growen = Growen::find($id);

        Growen::whereId($id)->delete();

        return redirect('/data4')->with('success', 'data deleted succesful');

    }  
}

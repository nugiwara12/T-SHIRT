<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Gueco;

class GuecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guecos = Gueco::orderBy('created_at', 'DESC')->get();
        return view('gueco.index', compact('guecos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gueco.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('gueco.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Save the data using the gueco model
        $gueco = new Gueco;
        $gueco->title = $request->input('title');
        $gueco->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gueco'), $imageName);

            // Save the full path or URL of the image in the database
            $gueco->image = 'gueco/' . $imageName;
        }

        $gueco->save();

        return redirect()->route('gueco.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gueco = Gueco::findOrFail($id);
        return view('gueco.show', compact('gueco'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gueco = Gueco::findOrFail($id);
        return view('gueco.edit', compact('guecos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gueco = Gueco::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $gueco->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('gueco.index')->with('success', 'Gueco updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gueco = Gueco::findOrFail($id);
        $gueco->delete();

        return redirect()->route('gueco.index')->with('success', 'Post deleted successfully');
    }
}


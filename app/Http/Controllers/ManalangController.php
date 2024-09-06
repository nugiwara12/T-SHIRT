<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Manalang;

class ManalangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manalangs = manalang::orderBy('created_at', 'DESC')->get();
        return view('manalang.index', compact('manalangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manalang.create');
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
            return redirect()->route('manalang.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Save the data using the manalang model
        $manalang = new Manalang;
        $manalang->title = $request->input('title');
        $manalang->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('manalang'), $imageName);

            // Save the full path or URL of the image in the database
            $manalang->image = 'manalang/' . $imageName;
        }

        $manalang->save();

        return redirect()->route('manalang.index')->with('success', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manalang = Manalang::findOrFail($id);
        return view('manalang.show', compact('manalang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $manalang = Manalang::findOrFail($id);
        return view('manalang.edit', compact('manalangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $manalang = Manalang::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // Update specific fields
        $manalang->update([
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('manalang.index')->with('success', 'Manalang updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $manalang = Manalang::findOrFail($id);
        $manalang->delete();

        return redirect()->route('manalang.index')->with('success', 'Post deleted successfully');
    }
}


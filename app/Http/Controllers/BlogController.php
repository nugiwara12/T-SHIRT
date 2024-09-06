<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        $blogs = Blog::orderBy('created_at', 'DESC')->get();

        return view('blog.index', compact('blogs'));
    }

    public function detail($id)
    {

        $blog = Blog::find($id);
        return view('detail', ['blog' => $blog]);
    }

    public function data()
    {
        return view('blog.index', [
            'blogs' => Blog::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogs = Blog::all();
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required', // Change 'description' to 'desc'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('blog.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Save the data using the granada model
        $blog = new Blog;
        $blog->title = $request->input('title');
        $blog->desc = $request->input('desc'); // Change 'description' to 'desc'
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('kagawad2'), $imageName);
    
            // Save the full path or URL of the image in the database
            $blog->image = 'kagawad2/' . $imageName;
        }
    
        $blog->save();
    
        return redirect('/data')->with('success', 'data Created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogs = Blog::findOrFail($id);

        return view('blog.show', compact('blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blogs = Blog::findOrFail($id);

        return view('blog.edit', compact('blogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $blog = Blog::find($id);

    $rules = [
        'title' => 'required',
        'image' => 'nullable|max:1000|mimes:jpg,jpeg,png', // Allow null for cases where no new image is uploaded
        'desc' => 'required|min:20',
    ];

    $this->validate($request, $rules);

    if ($request->hasFile('image')) {
        // Delete old image file
        if (File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('kagawad2'), $imageName);

        // Save the full path or URL of the image in the database
        $blog->image = 'kagawad2/' . $imageName;
    }

    // Update other fields
    $blog->title = $request->title;
    $blog->desc = $request->desc;
    $blog->save();

    return redirect('/data')->with('success', 'Data edit successful');
}



    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $blog = Blog::find($id);

        Blog::whereId($id)->delete();

        return redirect('/data')->with('success', 'data deleted succesful');

    }  
}

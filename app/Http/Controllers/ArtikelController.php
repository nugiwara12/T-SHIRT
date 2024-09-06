<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ArtikelController extends Controller
{
    public function index()
    {
        return view('artikel.index', [
            'artikels' => Artikels::all()
        ]);
    }

    public function detail($id)
    {

        $artikel = Artikels::find($id);
        return view('detail', ['artikel' => $artikel]);
    }

    public function data()
    {
        return view('artikle.index', [
            'artikels' => Artikels::all()
        ]);
    }

    public function create()
    {
        return view('artikle.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' =>'required',
            'image' =>'required|max:1000|mimes:jpg,jpeg,png',
            'desc' =>'required|min:20',
        ];

        $messages = [
            'title.required' => 'title was required!',
            'image.required' => 'image was required!',
            'desc.required' => 'desc was required!',
        ];

        $this->validate($request, $rules, $messages);

        // Image
        $fileName = time().'.'.$request->image->extension();
        $request->file('image')->storeAs('public/artikel', $fileName);

        // Artikel
        $storage = "storage/content-artikel";
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($request->desc, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                $fileNameContent = uniqid();
                $fileNameContentRand = substr(md5($fileNameContent),6,6).'_'.time();
                $filePath = ("$storage/$fileNameContentRand.$mimetype");
                $image = Image::make($src)->resize(1200,1200)->encode($mimetype, 100)->save(public_path($filePath));
                $new_src = asset($filePath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
                $img->setAttribute('class', 'img-responsive');
            }
        }

        Artikels::create([
            'title' => $request->title,
            'image' => $fileName,
            'desc' => $dom->saveHTML(),
        ]);

        return redirect('/create')->with('success', 'data Created successful');
    }

    public function edit($id)
    {
        $artikel = Artikels::find($id);
        return view('artikle.edit', ['artikel' => $artikel]);
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikels::find($id);

        if ($request->hasFile('image')) {
            $fileCheck = 'required|max:1000|mimes:jpg,jpeg,png';
        } else {
            $fileCheck = 'max:1000|mimes:jpg,jpeg,png';
        }

        $rules = [
            'title' =>'required',
            'image' => $fileCheck,
            'desc' =>'required|min:20',
        ];

        $messages = [
            'title.required' => 'title wajib diisi!',
            'image.required' => 'image wajib diisi!',
            'desc.required' => 'desc wajib diisi!',
        ];

        $this->validate($request, $rules, $messages);

        // Image
       if ($request->hasFile('image')) {
            if (\File::exists('storage/artikel/'.$artikel->image)) {
                \File::delete('storage/artikel/'.$artikel->image);
            }
            $fileName = time().'.'.$request->image->extension();
            $request->file('image')->storeAs('public/artikel', $fileName);
       }

       if ($request->hasFile('image')) {
            $checkFileName = $fileName;
       } else {
         $checkFileName = $artikel->image;
       }

        // Artikel
        $storage = "storage/content-artikel";
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($request->desc, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                $fileNameContent = uniqid();
                $fileNameContentRand = substr(md5($fileNameContent),6,6).'_'.time();
                $filePath = ("$storage/$fileNameContentRand.$mimetype");
                $image = Image::make($src)->resize(1200,1200)->encode($mimetype, 100)->save(public_path($filePath));
                $new_src = asset($filePath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
                $img->setAttribute('class', 'img-responsive');
            }
        }

        $artikel->update([
            'judul' => $request->judul,
            'image' => $checkFileName,
            'desc' => $dom->saveHTML(),
        ]);

        return redirect('/edit/'.$id)->with('success', 'data edit successful');

    }

    public function delete($id)
    {
        $artikel = Artikels::find($id);
        if (\File::exists('storage/artikel/'.$artikel->image)) {
            \File::delete('storage/artikel/'.$artikel->image);
        }

        Artikels::whereId($id)->delete();

        return redirect('/data')->with('success', 'data deleted succesful');

    }  
}


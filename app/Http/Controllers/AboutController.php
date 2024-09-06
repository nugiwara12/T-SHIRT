<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Angelica;
use App\Models\Deleon;
use App\Models\Galang;

use App\Models\Growen;
use App\Models\Christina;
use App\Models\Arvhie;
use App\Models\Macabanti;
use App\Models\Adriano;
use App\Models\Manlapaz;
use App\Models\Granada;






use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function create1()
    {
        $growens = Growen::all(); // Replace with your actual query to fetch articles
        return view('agustin', ['growens' => $growens]);
    }

    public function create2()
    {
        $macabantis = Macabanti::all(); // Replace with your actual query to fetch articles
        return view('macabanti', ['macabantis' => $macabantis]);
    }

    public function create3()
    {
        $granadas = Granada::all(); // Replace with your actual query to fetch articles
        return view('glenn', ['granadas' => $granadas]);
    }

    public function create4()
    {
        $blogs = Blog::all(); // Replace with your actual query to fetch articles
        return view('dada', ['blogs' => $blogs]);
    }
    
    public function create5()
    {
        $christinas = Christina::all(); // Replace with your actual query to fetch articles
        return view('christine', ['christinas' => $christinas]);
    }

    public function create6()
    {
        $arvhies = Arvhie::all(); // Replace with your actual query to fetch articles
        return view('arvhee', ['arvhies' => $arvhies]);
    }
    
    public function create7()
    {
        $angelicas = Angelica::all(); // Replace with your actual query to fetch articles
        return view('magsino', ['angelicas' => $angelicas]);
    }

    public function create9()
    {
        $artikels = Blog::all(); // Replace with your actual query to fetch articles
        return view('about', ['artikels' => $artikels]);
    }

    public function create10()
    {
        $adrianos = Adriano::all(); // Replace with your actual query to fetch articles
        return view('adriano', ['adrianos' => $adrianos]);
    }

    public function create11()
    {
        $manlapazs = Manlapaz::all(); // Replace with your actual query to fetch articles
        return view('abelle', ['manlapazs' => $manlapazs]);
    }

    public function create12()
    {
        $deleons = Deleon::all();
        $samples = Angelica::all();
        $artikels = Blog::all();
        $granadas = Granada::all();
        $growens = Growen::all();
        $christinas = Christina::all();
        $arvhies = Arvhie::all();
        $macabantis = Macabanti::all();
        $galangs = Galang::all();
        $manlapazs = Manlapaz::all();

        return view('deleon', [
            'deleons' => $deleons,
            'samples' => $samples,
            'artikels' => $artikels,
            'granadas' => $granadas,
            'growens' => $growens,
            'christinas' => $christinas,
            'arvhies' => $arvhies,
            'macabantis' => $macabantis,
            'galangs' => $galangs,
            'manlapazs' => $manlapazs


        ]);
    }

    public function create13()
    {
        $galangs = Galang::all(); // Replace with your actual query to fetch articles
        return view('galang', ['galangs' => $galangs]);
    }

    

}

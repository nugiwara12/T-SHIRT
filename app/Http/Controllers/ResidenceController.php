<?php

namespace App\Http\Controllers;
use App\Models\Residence;
use PDF;

use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    public function index()
    {
        $residences = Residence::all();
        return view('residence.index', compact('residences'));
    }

    public function create()
    {
        return view('residence.create');
    }

    public function create1()
    {
        return view('residence.create1');
    }

    public function create3()
    {
        return view('residence.create3');
    }

    public function create4()
    {
        return view('residence.create4');
    }


    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'date_start' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:200',
            'date_of_birth' => 'required|date',
            'generated_number' => 'required|integer',
            // Add more validation rules as needed
        ]);
    
        // Create a new certification instance and save it to the database
        $residence = Residence::create($validatedData);
    
        // Additional store logic if needed
    
        return redirect()->route('residence.index')->with('success', 'Residence created successfully!');
    }

    public function store1(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'date_start' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:200',
            'date_of_birth' => 'required|date',
            'generated_number' => 'required|integer',
            // Add more validation rules as needed
        ]);
    
        // Create a new residence instance and save it to the database
        $residence = Residence::create($validatedData);
    
        // Additional store logic if needed
    
        return redirect()->route('residence.create1')->with('success', 'Residence created successfully!');
    }


    public function store4(Request $request)
{
    // Validation
    $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'date_start' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:17',
            'date_of_birth' => 'required|date',
            'generated_number' => 'required|integer',
        // Add more validation rules as needed
    ]);

    // Create a new residence instance and save it to the database
    $residence = Residence::create($validatedData);

    // Additional store logic if needed

    return redirect()->route('residence.index')->with('success', 'Minor Residence created successfully!');
}



    public function store5(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'date_start' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:17',
            'date_of_birth' => 'required|date',
            'generated_number' => 'required|integer',
            // Add more validation rules as needed
        ]);
    
        // Create a new certification instance and save it to the database
        $residence = Residence::create($validatedData);
    
        // Additional store logic if needed
    
        return redirect()->route('residence.create4')->with('success', 'Minor Residence created successfully!');
    }

    public function edit($id)
    {
        $residences = Residence::findOrFail($id);
        return view('residence.edit', compact('residences'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mother_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'date_start'=>'required|string|max:255',
        ]);

        $Residence = Residence::findOrFail($id);
        $Residence->update($request->all());
        

        return redirect()->route('residence.index')
            ->with('success', 'Residence updated successfully.');
    }

    public function show($id)
    {
        $residence = Residence::findOrFail($id);
        return view('residence.show', compact('residence'));

        $residence = Certification::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('residence.pdf', compact('residence'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('residence.pdf');
    }

    public function generatePdf($id)
    {
        $residence = Residence::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('residence.pdf', compact('residence'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('residence.pdf');
    }

    public function show2($id)
    {
        $residence = Residence::findOrFail($id);
        return view('residence.show2', compact('residence'));

        $residence = Certification::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('residence.pdf2', compact('residence'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('residence.pdf2');
    }

    public function generatePdf2($id)
    {
        $residence = Residence::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('residence.pdf2', compact('residence'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('residence.pdf2');
    }

    public function destroy($id)
    {
        $residence = Residence::findOrFail($id);
        $residence->delete();

        return redirect()->route('residence.index')->with('success', 'Residence deleted successfully!');
    }
}

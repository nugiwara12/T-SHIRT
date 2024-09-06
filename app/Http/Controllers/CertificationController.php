<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certification;
use PDF;
use Illuminate\Support\Facades\Storage;


class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::all();
        return view('certification.index', compact('certifications'));
    }

    public function create()
    {
        return view('certification.create');
    }

    public function create1()
    {
        return view('certification.create1');
    }

    public function create3()
    {
        return view('certification.create3');
    }

    public function create4()
    {
        return view('certification.create4');
    }


    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'age' => 'nullable|integer|min:18|max:200',
            'date' => 'required|date',
            // 'minor' => 'required|string',
            'date_of_birth' => 'required|date',
            'generated_number' => 'required|string', // Update the validation based on your requirements
    
            // Add more validation rules as needed
        ]);
    
        // Additional logic to generate and set the value for 'generated_number'
    
        // Create a new certification instance and save it to the database
        $certification = Certification::create($validatedData);
    
        // Additional store logic if needed
    
        return redirect()->route('certification.index')->with('success', 'Certification created successfully!');
    }
    

    public function store1(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'age' => 'nullable|integer|min:18|max:200',
            'date' => 'required|date',
            'date_of_birth' => 'required|date',
            // 'minor' => 'required|string',
            'generated_number' => 'required|string', // Update the validation based on your requirements
            // Add more validation rules as needed
        ]);
    
        // Create a new certification instance and save it to the database
        $certification = Certification::create($validatedData);
    
        // Additional store logic if needed
    
        return redirect()->route('certification.create1')->with('success', 'Certification created successfully!');
    }

    public function store3(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'age' => 'nullable|integer|min:1|max:17',
            'date' => 'required|date',
            'age' => 'nullable|integer|min:1|max:17',
            'minor' => 'required|string',
            'date_of_birth' => 'required|date',
            'generated_number' => 'required|string', // Update the validation based on your requirements
    
            // Add more validation rules as needed
        ]);
    
        // Additional logic to generate and set the value for 'generated_number'
    
        // Create a new certification instance and save it to the database
        $certification = Certification::create($validatedData);
    
        // Additional store logic if needed
    
        return redirect()->route('certification.index')->with('success', 'Certification created successfully!');
    }

    public function store4(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'mother_name' => 'required|string|max:255',
            'your_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'age' => 'nullable|integer|min:1|max:17',
            'date' => 'required|date',
            'date_of_birth' => 'required|date',
            'minor' => 'required|string',
            'generated_number' => 'required|string', // Update the validation based on your requirements
    
            // Add more validation rules as needed
        ]);
    
        // Additional logic to generate and set the value for 'generated_number'
    
        // Create a new certification instance and save it to the database
        $certification = Certification::create($validatedData);
    
        // Additional store logic if needed
    
        return redirect()->route('certification.create4')->with('success', 'Certification created successfully!');
    }

    public function edit($id)
    {
        $certification = Certification::findOrFail($id);
        return view('certification.edit', compact('certification'));
    }

    public function update(Request $request, $id)
    {
        $certification = Certification::findOrFail($id);

        // Validation logic here (similar to the previous example)

        $certification->update([
            'mother_name' => $request->input('mother_name'),
            'address' => $request->input('address'),
            'purpose' => $request->input('purpose'),
            'your_name' => $request->input('your_name'),
            'age' => $request->input('age'),
            'date' => $request->input('date'),
            'date_of_birth' => $request->input('date_of_birth'),

        ]);

        // Redirect back to the edit page with a success message
        return redirect()->route('certification.index', ['id' => $certification->id])->with('success', 'Certification updated successfully');
    }

    public function show($id)
    {
        $certification = Certification::findOrFail($id);
        return view('certification.show', compact('certification'));

        $certification = Certification::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('certification.pdf', compact('certification'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('certification.pdf');
    }

    public function generatePdf($id)
    {
        $certification = Certification::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('certification.pdf', compact('certification'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('certification.pdf');
    }

    public function show2($id)
    {
        $certification = Certification::findOrFail($id);
        return view('certification.show2', compact('certification'));

        $certification = Certification::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('certification.pdf2', compact('certification'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('certification.pdf2');
    }

    public function generatePdf2($id)
    {
        $certification = Certification::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('certification.pdf2', compact('certification'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('certification.pdf2');
    }

    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();

        return redirect()->route('certification.index')->with('success', 'Certification deleted successfully!');
    }
}
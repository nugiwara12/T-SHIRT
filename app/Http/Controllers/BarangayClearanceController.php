<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangayClearance;
use PDF;

class BarangayClearanceController extends Controller
{
    public function index()
    {
        $clearances = BarangayClearance::all();
        return view('barangay_clearances.index', compact('clearances'));
    }

    public function create()
    {
        return view('barangay_clearances.create');
    }

    public function create1()
    {
        return view('barangay_clearances.create1');
    }

    public function create3()
    {
        return view('barangay_clearances.create3');
    }

    public function create4()
    {
        return view('barangay_clearances.create4');
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'reason' => 'required|string',
            'age' => 'nullable|integer|min:0',
            // 'minor' => 'required|string',
            'generated_number' => 'required|integer',
        ]);

        BarangayClearance::create($request->all());

        return redirect()->route('barangay_clearances.index')
            ->with('success', 'Barangay Clearance created successfully.');
    }

    public function store1(Request $request)
    {
        $request->validate([
            'parent' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'reason' => 'required|string',
            'age' => 'nullable|integer|min:0',
            // 'minor' => 'required|string',
            'generated_number' => 'required|integer',
        ]);

        BarangayClearance::create($request->all());

        return redirect()->route('barangay_clearances.create1')
            ->with('success', 'Barangay Clearance created successfully.');
    }

    public function store2(Request $request)
    {
        $request->validate([
            'parent' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'reason' => 'required|string',
            'minor' => 'required|string',
            'age' => 'nullable|integer|min:0',
            'generated_number' => 'required|integer',
        ]);

        BarangayClearance::create($request->all());

        return redirect()->route('barangay_clearances.create')
            ->with('success', 'Barangay Clearance created successfully.');
    }

    public function store3(Request $request)
{
    $request->validate([
        'parent' => 'required|string',
        'name' => 'required|string',
        'address' => 'required|string',
        'reason' => 'required|string',
        'minor' => 'required|string',
        'age' => 'nullable|integer|min:0',
        'generated_number' => 'required|integer',
    ]);

    BarangayClearance::create($request->all());

    return redirect()->route('barangay_clearances.index')
        ->with('success', 'Barangay Clearance created successfully.');
}


    public function store4(Request $request)
    {
        $request->validate([
            'parent' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'reason' => 'required|string',
            'minor' => 'required|string',
            'age' => 'nullable|integer|min:0',
            'generated_number' => 'required|integer',
        ]);

        BarangayClearance::create($request->all());

        return redirect()->route('barangay_clearances.create4')
            ->with('success', 'Minor Barangay Clearance created successfully.');
    }
    public function edit($id)
    {
        $barangay_clearances = BarangayClearance::findOrFail($id);
        return view('barangay_clearances.edit', compact('barangay_clearances'));
    }

    public function update(Request $request, $id)
{
    // Validation
    $validatedData = $request->validate([
        'parent' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'reason' => 'required|string',
        'age' => 'nullable|integer|min:0|max:200',
        // Add more validation rules as needed
    ]);

    // Find the Barangay Clearance by ID
    $barangayClearance = BarangayClearance::find($id);

    // Check if the model exists
    if (!$barangayClearance) {
        return redirect()->route('barangay_clearances.index')->with('error', 'Barangay Clearance not found.');
    }

    // Update the model with the validated data
    $barangayClearance->update($validatedData);

    // Redirect to the index page with a success message
    return redirect()->route('barangay_clearances.index')->with('success', 'Barangay Clearance updated successfully!');
}



    public function show($id)
    {
        $barangay_clearance = BarangayClearance::findOrFail($id);
        return view('barangay_clearances.show', compact('barangay_clearance'));


         // Load the view for PDF
         $pdf = PDF::loadView('barangay_clearances.pdf', compact('barangay_clearance'));

         // Uncomment the line below if you want to download the PDF
         // return $pdf->download('certification.pdf');
 
         // Comment the line below if you want to download the PDF
         return $pdf->stream('barangay_clearances.pdf');
    }

    public function generatePdf($id)
    {
        $barangay_clearance = BarangayClearance::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('barangay_clearances.pdf', compact('barangay_clearance'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('barangay_clearances.pdf');
    }

    public function show2($id)
    {
        $barangay_clearance = BarangayClearance::findOrFail($id);
        return view('barangay_clearances.show2', compact('barangay_clearance'));


         // Load the view for PDF
         $pdf = PDF::loadView('barangay_clearances.pdf', compact('barangay_clearance'));

         // Uncomment the line below if you want to download the PDF
         // return $pdf->download('certification.pdf');
 
         // Comment the line below if you want to download the PDF
         return $pdf->stream('barangay_clearances.pdf2');
    }

    public function generatePdf2($id)
    {
        $barangay_clearance = BarangayClearance::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('barangay_clearances.pdf2', compact('barangay_clearance'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('barangay_clearances.pdf2');
    }








    public function destroy($id)
    {
        $clearance = BarangayClearance::findOrFail($id);
        $clearance->delete();

        return redirect()->route('barangay_clearances.index')
            ->with('success', 'Barangay Clearance deleted successfully.');
    }

    

}

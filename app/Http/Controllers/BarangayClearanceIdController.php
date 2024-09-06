<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Support\Facades\File; // Add this import statement
use App\Models\Barangay_ids;
use PDF;

class BarangayClearanceIdController extends Controller
{

    protected $fillable = [
        'image',
        'name',
        'address',
        'date_of_birth',
        'place_of_birth',
        'citizenship',
        'gender',
        'civil_status',
        'contact_no',
        'relation',
        'generated_number',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Use the correct model and namespace
        $barangay_ids = Barangay_ids::orderBy('created_at', 'DESC')->get();

        return view('barangay-clearance-id.index', compact('barangay_ids'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barangay-clearance-id.create')
        ->with('success', 'Barangay ID Created successfully.');
    }


    public function create1()
    {
        return view('/barangayid')
        ->with('success', 'Barangay ID Created successfully.');
    }

    public function create5()
    {
        return view('barangay-clearance-id.create5')
        ->with('success', 'Barangay ID Created successfully.');
    }


    public function create7()
    {
        return view('barangay-clearance-id.create7')
        ->with('success', 'Barangay ID Created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'age' => 'required|integer|between:18,200',
                'citizenship' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'civil_status' => 'required|string|max:255',
                'contact_no' => 'required|string|max:255',
                'guardian' => 'required|string|max:255',
                'relation' => 'required|string|max:255',
                'generated_number' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return redirect()->route('barangay-clearance-id.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Mass assignment using fillable properties
        $barangay_id = Barangay_ids::create($request->only($this->fillable));

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('ID-image'), $imageName);

            // Update the image attribute separately
            $barangay_id->update(['image' => 'ID-image/' . $imageName]);
        }

    $barangay_id->save();

    return redirect()->route('barangay-clearance-id.index')
        ->with('success', 'Barangay ID created successfully.');
}

public function store1(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'age' => 'required|integer|between:18,200',
                'citizenship' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'civil_status' => 'required|string|max:255',
                'contact_no' => 'required|string|max:255',
                'guardian' => 'required|string|max:255',
                'relation' => 'required|string|max:255',
                'generated_number' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return redirect()->route('barangay-clearance-id.create1')
                ->withErrors($validator)
                ->withInput();
        }

        // Mass assignment using fillable properties
        $barangay_id = Barangay_ids::create($request->only($this->fillable));

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('ID-image'), $imageName);

            // Update the image attribute separately
            $barangay_id->update(['image' => 'ID-image/' . $imageName]);
        }

    $barangay_id->save();

    return redirect()->route('barangay-clearance-id.create1')
        ->with('success', 'Barangay ID created successfully.');
}


public function store5(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'age' => 'required|integer|between:1,17',
                'citizenship' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'civil_status' => 'required|string|max:255',
                'contact_no' => 'required|string|max:255',
                'guardian' => 'required|string|max:255',
                'relation' => 'required|string|max:255',
                'generated_number' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return redirect()->route('barangay-clearance-id.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Mass assignment using fillable properties
        $barangay_id = Barangay_ids::create($request->only($this->fillable));

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('ID-image'), $imageName);

            // Update the image attribute separately
            $barangay_id->update(['image' => 'ID-image/' . $imageName]);
        }

    $barangay_id->save();

    return redirect()->route('barangay-clearance-id.index')
        ->with('success', 'Barangay ID created successfully.');
}

public function store7(Request $request)
{
    $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'age' => 'required|integer|between:1,17',
                'citizenship' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'civil_status' => 'required|string|max:255',
                'contact_no' => 'required|string|max:255',
                'guardian' => 'required|string|max:255',
                'relation' => 'required|string|max:255',
                'generated_number' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return redirect()->route('barangay-clearance-id.create7')
            ->withErrors($validator)
            ->withInput();
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        $imageFile = $request->file('image');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();

        // Move the uploaded file to the public/ID-image directory
        $imageFile->move(public_path('ID-image'), $imageName);
    }

    // Mass assignment using fillable properties
    $barangay_id = Barangay_ids::create(array_merge(
        $request->only($this->fillable),
        ['image' => 'ID-image/' . $imageName]
    ));

    return redirect()->route('barangay-clearance-id.create7')
        ->with('success', 'Barangay ID created successfully.');
}



    
    /**
     * Display the specified resource.
     */
    public function frontShow($id)
    {
        $barangay_ids = Barangay_ids::find($id);

        return view('barangay-clearance-id.frontShow', ['barangay_ids' => $barangay_ids])
        ->with('success', 'Barangay ID Updated successfully.');

        // Load the view for PDF
        $pdf = PDF::loadView('barangay-clearance-id.pdf', compact('barangay_ids'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('barangay-clearance-id.pdf');
    }

    public function generatePdf($id)
    {
        $barangay_ids = Barangay_ids::findOrFail($id);

        // Make sure to use the full URL with asset() function
        $imagePath = asset('storage/images/' . $barangay_ids->image);

        // Load the view for PDF
        $pdf = PDF::loadView('barangay-clearance-id.pdf', compact('barangay_ids'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('barangay-clearance-id.pdf');
    }

    public function backShow($id)
    {
        $barangay_ids = Barangay_ids::find($id);

        return view('barangay-clearance-id.backShow', ['barangay_ids' => $barangay_ids]);

        // Load the view for PDF
        $pdf = PDF::loadView('barangay-clearance-id.pdf2', compact('barangay_ids'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('barangay-clearance-id.pdf2');
    }

    public function generatePdf2($id)
    {
        $barangay_ids = Barangay_ids::findOrFail($id);

        // Load the view for PDF
        $pdf = PDF::loadView('barangay-clearance-id.pdf2', compact('barangay_ids'));

        // Uncomment the line below if you want to download the PDF
        // return $pdf->download('certification.pdf');

        // Comment the line below if you want to download the PDF
        return $pdf->stream('barangay-clearance-id.pdf2');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barangay_ids = barangay_ids::find($id);

        return view('barangay-clearance-id.edit', ['id' => $id, 'barangay_ids' => $barangay_ids])
        ->with('success', 'Barangay ID Edit successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, $id)
    {
        // Validate and update the clearance information
        $barangay_ids = barangay_ids::find($id);
        $barangay_ids->update($request->all());

        return redirect()->route('barangay-clearance-id.index', ['id' => $barangay_ids->id])
        ->with('success', 'Barangay ID Edit successfully.');
        }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find and delete the clearance
        $barangay_ids = Barangay_ids::find($id);
        $barangay_ids->delete();

        return redirect()->route('barangay-clearance-id.index')
        ->with('success', 'Barangay ID Deleted successfully.'); // Redirect to clearance listing page
    }

}

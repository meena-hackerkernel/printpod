<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\ZipCode;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('zipCode')->orderBy('id', 'desc')->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        $zipCodes = ZipCode::whereNotIn('id', Vendor::pluck('zip_code_id'))->get();

        return view('admin.vendors.create', compact('zipCodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zip_code_id' => 'required|unique:vendors,zip_code_id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|regex:/^[0-9]{10}$/|unique:vendors,phone_number',
            'email' => 'required|email|unique:vendors,email',
        ]);

        Vendor::create($request->all());

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor added successfully!');
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        $zipCodes = ZipCode::all(); // Fetch all ZIP Codes for dropdown
        return view('admin.vendors.edit', compact('vendor', 'zipCodes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:vendors,email,' . $id,
            'phone_number' => 'required|string|max:20|unique:vendors,phone_number,' . $id,
            'address' => 'required|string|max:500',
            'zip_code_id' => 'required|exists:zip_codes,id|unique:vendors,zip_code_id,' . $id,
            'status' => 'required|boolean',
        ]);
    
        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());
    
        return response()->json([
            'success' => true,
            'message' => 'Vendor updated successfully.'
        ]);
    }
    

    public function destroy($id)
    {
        $Vendor = Vendor::find($id);

        if (!$Vendor) {
            return response()->json([
                'success' => false,
                'message' => 'ZIP Code not found.'
            ], 404);
        }

        $Vendor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vendor deleted successfully!'
        ]);
    }

    public function show(string $id)
    {
        $vendor = Vendor::with('zipCode')->findOrFail($id);
        return view('admin.vendors.show', compact('vendor'));
    }


    public function changeStatus($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->status = !$vendor->status;
        $vendor->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

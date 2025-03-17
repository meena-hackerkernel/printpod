<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZipCode;
use Illuminate\Http\Request;

class ZipCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zipCodes = ZipCode::orderBy('id', 'desc')->paginate(10);
        return view('admin.zip_codes.index', compact('zipCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.zip_codes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'zip_code' => 'required|unique:zip_codes,zip_code',
            // 'city' => 'required',
            // 'state' => 'required',
        ]);

        $zipCode = new ZipCode();
        $zipCode->zip_code = $request->zip_code;
        $zipCode->save();

        return response()->json([
            'success' => true,
            'message' => 'ZIP Code added successfully!'
        ]);

        return redirect()->route('admin.zip-codes.index')->with('success', 'ZIP Code added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zipCode = ZipCode::findOrFail($id);
        return view('admin.zip_codes.show', compact('zipCode'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $zipCode = ZipCode::find($id);
        return view('admin.zip_codes.edit', compact('zipCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $zipCode = ZipCode::find($id);

        if (!$zipCode) {
            return response()->json([
                'success' => false,
                'message' => 'ZIP Code not found.'
            ], 404);
        }

        $request->validate([
            'zip_code' => 'required|unique:zip_codes,zip_code,' . $id,
            // 'city' => 'required',
            // 'state' => 'required',
        ]);

        $zipCode->zip_code = $request->zip_code;
        $zipCode->save();


        return response()->json([
            'success' => true,
            'message' => 'ZIP Code updated successfully!'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zipCode = ZipCode::find($id);

        if (!$zipCode) {
            return response()->json([
                'success' => false,
                'message' => 'ZIP Code not found.'
            ], 404);
        }

        $zipCode->delete();

        return response()->json([
            'success' => true,
            'message' => 'ZIP Code deleted successfully!'
        ]);
    }
}

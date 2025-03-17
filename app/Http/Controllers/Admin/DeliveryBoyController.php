<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryBoy;
use App\Models\ZipCode;
use Illuminate\Http\Request;

class DeliveryBoyController extends Controller
{
    public function index()
    {
        $deliveryBoys = DeliveryBoy::with('zipCode')->orderBy('id', 'desc')->paginate(10);
        return view('admin.delivery_boys.index', compact('deliveryBoys'));
    }

    public function create()
    {
        $zipCodes = ZipCode::all();
        return view('admin.delivery_boys.create', compact('zipCodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zip_code_id' => 'required|exists:zip_codes,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|regex:/^[0-9]{10}$/|unique:delivery_boys,phone_number',
            'email' => 'required|email|unique:delivery_boys,email',
        ]);

        DeliveryBoy::create($request->all());

        return redirect()->route('admin.delivery-boys.index')->with('success', 'Delivery boy added successfully!');
    }

    public function edit($id)
    {
        $deliveryBoy = DeliveryBoy::findOrFail($id);
        $zipCodes = ZipCode::all();
        return view('admin.delivery_boys.edit', compact('deliveryBoy', 'zipCodes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:delivery_boys,email,' . $id,
            'phone_number' => 'required|string|max:20|unique:delivery_boys,phone_number,' . $id,
            'address' => 'required|string|max:500',
            'zip_code_id' => 'required|exists:zip_codes,id',
            'status' => 'required|boolean',
        ]);

        $deliveryBoy = DeliveryBoy::findOrFail($id);
        $deliveryBoy->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Delivery boy updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $deliveryBoy = DeliveryBoy::find($id);

        if (!$deliveryBoy) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery boy not found.'
            ], 404);
        }

        $deliveryBoy->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delivery boy deleted successfully!'
        ]);
    }

    public function show($id)
    {
        $deliveryBoy = DeliveryBoy::with('zipCode')->findOrFail($id);
        return view('admin.delivery_boys.show', compact('deliveryBoy'));
    }

    public function changeStatus($id)
    {
        $deliveryBoy = DeliveryBoy::findOrFail($id);
        $deliveryBoy->status = !$deliveryBoy->status;
        $deliveryBoy->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

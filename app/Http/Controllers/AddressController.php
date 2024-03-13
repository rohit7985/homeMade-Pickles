<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'mobile_num' => 'required|string|max:20',
                'pincode' => 'required|numeric',
                'address' => 'required|string',
            ]);
            $address = new Address();
            $address->fill($validatedData);
            $address->user_id = auth()->user()->id;
            $address->save();
            return redirect()->route('customer.address')->with('success', 'Address added successfully!');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function viewAddress()
    {
        try {
            $customer = Auth::user();
            $addresses = Address::where('user_id', $customer->id)->get();
            return view('customerAddress', compact('addresses'));

      
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function editAddress($id)
    {
        try {
            $address = Address::find($id);
            if ($address) {
                return response()->json($address);
            } else {
                return response()->json(['error' => 'Address not found'], 404);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'mobile_num' => 'required|string|max:20',
                'pincode' => 'required|numeric',
                'address' => 'required|string',
            ]);
            $addressId = $request->input('address_id');
            $address = Address::find($addressId);
            if (!$address) {
                return redirect()->back()->with('error', 'Address not found.');
            }
            $address->name = $validatedData['name'];
            $address->mobile_num = $validatedData['mobile_num'];
            $address->pincode = $validatedData['pincode'];
            $address->address = $validatedData['address'];
            $address->save();
            return redirect()->route('customer.address')->with('success', 'Address updated successfully.');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function destroy(Request $request, Address $address)
    {
        try {
            $address->delete();
            if ($request->ajax()) {
                return response()->json(['success' => 'Product deleted successfully!']);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

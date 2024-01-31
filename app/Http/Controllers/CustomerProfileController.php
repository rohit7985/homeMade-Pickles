<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    public function myProfile()
    {
        try {
            $customer = Auth::user();
            return view('myProfile', compact('customer'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function addContact(Request $request)
    {
        try {
            $rules = [
                'customerId' => 'required|integer|exists:users,id',
                'mobile_number' => 'required|regex:/^\d{10}$/',
            ];
            $messages = [
                'customerId.exists' => 'Invalid customer ID.',
                'mobile_number.regex' => 'Invalid mobile number format.',
            ];
            $validatedData = $request->validate($rules, $messages);
            $customerId = $validatedData['customerId'];
            $mobileNumber = $validatedData['mobile_number'];
            if ($customerId) {
                $customer = User::findOrFail($customerId);
                $customer->mobile_number = $mobileNumber;
                $customer->save();
            }
            return redirect()->back()->with('success', 'Contact details added successfully');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function myOrder()
    {
        try {
            $customer = Auth::user();
            $orders = Order::where('customer_id', $customer->id)->get();
            return view('customer.customerOrderDetails', compact('customer', 'orders'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

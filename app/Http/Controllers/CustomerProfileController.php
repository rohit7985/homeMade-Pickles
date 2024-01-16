<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
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

    public function myOrder()
    {
        try {
            $customer = Auth::user();
            $orders = Order::where('customer_id',$customer->id)->get();
            // dd($orders);
            return view('customer.customerOrderDetails', compact('customer','orders'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

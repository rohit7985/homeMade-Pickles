<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function updateStatus($id)
    {
        try {
            // dd($id);
            $customer = User::find($id);
            // dd($customer);
            if ($customer->status == '1') {
                $customer->status = '2';
            } else {
                $customer->status = '1';
            }
            $customer->save();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function filter(Request $request)
    {
        try {
            $status = $request->input('status');
            $customers = User::where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            return view('admin.customers', compact('customers'));
                } catch (\Exception $e) {
            dd($e);
        }
    }
}

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
}

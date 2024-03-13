<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function myProfile()
    {
        try {
            $user = Auth::user();
            return view('admin.adminProfile', compact('user'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function approveAllPending()
    {
        try {
            $pendingCustomers = User::where('status', '0')->get();
            User::where('status', '0')->update(['status' => '1']);
            foreach ($pendingCustomers as $customer) {
                $mailData = [
                    'title' => 'Account Status',
                    'body' => 'Status Updated',
                    'status' => 1,
                    'name' => "Sir/Ma'am",
                ];
                $subject = 'Home Made Pickles: Account Status Changed';
                Mail::bcc($customer->email)->send(new SendMail($mailData, $subject));
            }
            return response()->json(['message' => 'All pending customers approved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to approve pending customers'], 500);
        }
    }

    public function changeEmail(Request $request)
    {
        try {
            $request->validate([
                'customerId' => 'required|exists:users,id',
                'email' => 'required|email',
            ]);
            $user = Admin::findOrFail($request->input('customerId'));
            $user->email = $request->input('email');
            $user->save();
            return redirect()->back()->with('success', 'Email updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update email');
        }
    }

    public function updateStatus($id)
    {
        try {
            $customer = User::find($id);
            if ($customer->status == '1') {
                $customer->status = '2';
            } else {
                $customer->status = '1';
            }
            $customer->save();
            $mailData = [
                'title' => 'Account Status',
                'body' => 'Status Updated ',
                'name' => $customer->name,
                'status' => $customer->status,
            ];
            $subject = 'Home Made Pickles : Account Status Changed';
            Mail::to('rahulpatel979503@gmail.com')->send(new SendMail($mailData, $subject));
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function filter(Request $request)
    {
        try {
            $status = $request->input('status');
            $name = $request->input('name');
            $email = $request->input('email');
            $customersQuery = User::orderBy('created_at', 'desc');

            if (!is_null($status)) {
                $customersQuery->where('status', $status);
            }

            if (!is_null($name)) {
                $customersQuery->where('name', 'like', '%' . $name . '%');
            }

            if (!is_null($email)) {
                $customersQuery->where('email', 'like', '%' . $email . '%');
            }

            $customers = $customersQuery->paginate(10)->appends($request->except('page'));

            return view('admin.customers', compact('customers'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function approveSelectedCustomers(Request $request)
    {
        try {
            $customerIds = $request->input('customer_ids');
            User::whereIn('id', $customerIds)->update(['status' => 1]);
            $customerEmails = User::whereIn('id', $customerIds)->pluck('email')->toArray();
            $mailData = [
                'title' => 'Account Status',
                'body' => 'Status Updated',
                'status' => 1,
                'name' => "Sir/Ma'am",
            ];
            $subject = 'Home Made Pickles: Account Status Changed';
            Mail::bcc($customerEmails)->send(new SendMail($mailData, $subject));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            dd($e);
        }
    }



    public function filterProducts(Request $request)
    {
        try {
            $request->validate([
                'visibility' => 'nullable|boolean',
                'product' => 'nullable|string',
                'priceRange' => 'nullable|numeric', 
            ]);
            $visibility = $request->input('visibility');
            $product = $request->input('product');
            $priceRange = $request->input('priceRange');
            $productQuery = Product::orderBy('created_at', 'desc');
            // Apply filters based on validated input
            if (!is_null($visibility)) {
                $productQuery->where('hidden', $visibility);
            }
    
            if (!is_null($product)) {
                $productQuery->where('product', 'like', '%' . $product . '%');
            }
    
            if (!is_null($priceRange)) {
                $productQuery->where('price', '<=', $priceRange);
            }
    
            // Paginate results
            $products = $productQuery->paginate(10)->appends($request->except('page'));
            $request->flash();
    
            return view('admin.products', compact('products'));
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while filtering products. Please try again later.');
        }
    }
    
}

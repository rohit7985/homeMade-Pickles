<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use App\Models\merchant;
use App\Models\merchantDetails;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function index()
    {
        try {
            $user= Auth::user();
            // Count total users
            $totalUsers = User::count();

            // Count total orders
            $totalOrders = Order::count();

            // Count total products
            $totalProducts = Product::where('merchant_id',$user->id)->count();

            // Count pending orders (assuming there's a 'status' column in the orders table)
            $pendingOrders = Order::where('status', 'pending')->count();
            return view('merchant.index', compact('totalUsers', 'totalOrders', 'totalProducts', 'pendingOrders'));
        } catch (\Exception $e) {
            // Handle exceptions if needed
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function viewProduct()
    {
        try {
            $user= Auth::user();
            $products = Product::where('merchant_id', $user->id)->with('ratingReviews')
                ->orderBy('created_at', 'desc')
                ->paginate(6);

            foreach ($products as $product) {
                $averageRating = $product->ratingReviews->avg('rating');
                $product->averageRating = $averageRating;
            }

            return view('merchant.products', compact('products'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function myProfile()
    {
        try {
            $usr = Auth::user();
            $user = merchant::with('merchant')->find($usr->id);
            return view('merchant.merchantProfile', compact('user'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function changeData(Request $request)
    {
        try {
            // $request->validate([
            //     'merchantId' => 'required|exists:merchant_details,merchant_id',
            //     'bankName' => 'required',
            //     'ifsc_code' => 'required',
            //     'accNumber' => 'required|size:12',
            // ]);
            $user = merchantDetails::where('merchant_id', $request->merchantId)->first();
            if(!$user){
                $details = new merchantDetails;
                $details->merchant_id =  $request->merchantId;
                $details->name = $request->name;
                $details->dob = $request->dob;
                $details->mobile_number = $request->mobile_number;
                $details->save();
            }else{
                $user->bankName = $request->input('bankName');
            $user->ifsc_code = $request->input('ifsc_code');
            $user->accountNo = $request->input('accNumber');
            $user->save();
            }
            return redirect()->back()->with('success', 'Bank details updated successfully');
            
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Failed to update Bank details');
        }
    }

    public function changeBankDetails(Request $request)
    {
        try {
            $request->validate([
                'merchantId' => 'required|exists:merchant_details,merchant_id',
                'bankName' => 'required',
                'ifsc_code' => 'required',
                'accNumber' => 'required|size:12',
            ]);
            $user = merchantDetails::where('merchant_id', $request->merchantId)->first();
            $user->bankName = $request->input('bankName');
            $user->ifsc_code = $request->input('ifsc_code');
            $user->accountNo = $request->input('accNumber');
            $user->save();
            return redirect()->back()->with('success', 'Bank details updated successfully');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Failed to update Bank details');
        }
    }

    public function logout()
    {
        try {
            Auth::guard('merchant')->logout();
            return redirect('/merchant/login');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function viewMerchants()
    {
        try {
            $customers = User::where('user_type', 'M')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.merchants', compact('customers'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function merchantLogin(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::guard('merchant')->attempt($credentials)) {
                return redirect('/merchant/dashboard');
            } else {
                return back()->withInput($request->only('email'))->withErrors([
                    'email' => 'Invalid email or password',
                ]);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

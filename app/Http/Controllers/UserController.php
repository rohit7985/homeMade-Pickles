<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\userOTP;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'user_type' => $request->createdBy == 'Admin' ? 'M':'C',
                'password' => Hash::make($validatedData['password']),
            ]);
            if ($request->createdBy && $request->createdBy == 'Admin') {
                return redirect('/admin/customers');
            } else {
                $otp = rand(100000, 999999);
                userOTP::create([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'otp' => $otp,
                ]);
                $mailData = [
                    'title' => 'Varification',
                    'body' => 'Varification for OTP ',
                    'otp' => $otp,
                    'name' => $user->name,
                ];
                $subject = 'Home Made Pickles : Account Varification';
                Mail::to('rahulpatel979503@gmail.com')->send(new SendMail($mailData, $subject));
                return view('login', compact('user'));
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $storedOtp = userOTP::where('user_id', $request->user_id)
                ->where('email', $request->email)
                ->latest()
                ->first();
            if ($storedOtp && $request->otp == $storedOtp->otp) {
                $storedOtp->delete();
                $user = User::where('id', $request->user_id)->first();
                if ($user) {
                    $user->status = '1';
                    $user->save();
                }
                return redirect()->route('shop');
            } else {
                return back()->withErrors(['otp' => 'Invalid OTP, please try again']);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
                $cartItemCount = $cartItems->count();
                $otpVerified = userOTP::where('user_id', $user->id)->first();
                if ($user->status == '1') {
                    return redirect()->route('home');
                } elseif ($otpVerified) {
                    $currentTime = time();
                    $createdAtTimestamp = strtotime($otpVerified->created_at);
                    $isValid = $currentTime - $createdAtTimestamp;
                    if ($isValid > 305) {
                        return redirect()->route('login.view')->with(['otpExpr' => 'Your OTP has Expired, Send OTP Again', 'user' => $user, 'cartItemCount' => $cartItemCount]);
                    }
                } else {
                    return redirect()->route('login.view')->with('error', 'Rejected User Found, Please Contact to the Admin');
                }
            }
            return redirect()->route('login.view')->with('error', 'Invalid Credentials');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function showUserDetails($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $addresses = Address::where('user_id', $id)->get();
            $orders = Order::where('customer_id', $id)->get();
            return view('admin.viewCustomerDetails', compact('user', 'addresses', 'orders'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function searchUser(Request $request)
    {
        try {
            $query = $request->input('query');
            $user_type = $request->input('user_type') ?? 'C';
            if($user_type == 'M'){
            if ($query != '') {
                $users = User::where('user_type', 'M')->where('name', 'like', '%' . $query . '%')->get();
            } else {
                $users = User::where('user_type', 'M')->where('name', $query)->get();
            }
        }else{
            if ($query != '') {
                $users = User::where('user_type', 'C')->where('name', 'like', '%' . $query . '%')->get();
            } else {
                $users = User::where('user_type', 'C')->where('name', $query)->get();
            }
        }
            return response()->json($users);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return redirect('/login')->with('success', 'User Logout Successfuly');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function resendOTP($userId)
    {
        try {
            $userOTP = userOTP::where('user_id', $userId)->first();
            $user = User::where('id', $userId)->first();
            if ($userOTP) {
                $newOTP = mt_rand(100000, 999999);
                $userOTP->otp = $newOTP;
                $userOTP->save();
                $mailData = [
                    'title' => 'Varification',
                    'body' => 'Varification for OTP ',
                    'otp' => $newOTP,
                    'name' => $user->name,
                ];
                $subject = 'Home Made Pickles : Account Varification';
                Mail::to('rahulpatel979503@gmail.com')->send(new SendMail($mailData, $subject));
                return view('login', compact('user'));
            } else {
                return redirect()->route('login.view')->with('error', 'User not found!');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function viewCustomers()
    {
        try {
            $customers = User::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.customers', compact('customers'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function destroy(Request $request, User $customer)
    {
        try {

            $customer->delete();

            if ($request->ajax()) {
                return response()->json(['success' => 'Customer deleted successfully!']);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

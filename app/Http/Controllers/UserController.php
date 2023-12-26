<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
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
                'password' => Hash::make($validatedData['password']),
            ]);
            $otp = rand(1000, 9999);
            userOTP::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'otp' => $otp,
            ]);


            $mailData = [
                'title' => 'Varification',
                'body' => 'Varification for OTP ',
                'otp' => $otp,
            ];
            Mail::to('rahulpatel979503@gmail.com')->send(new SendMail($mailData));
            if ($request->createdBy && $request->createdBy == 'Admin') {
                return redirect('/admin/customers');
            } else {
                return view('login',compact('user'));
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
                $user = User::where('user_id', $request->user_id)->first();
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
                if($user->status == '1'){
                    return redirect()->route('home');
                }else{
                    return redirect()->route('login.view')->with('error', 'Invalid User');
                }  
            }
            return redirect()->route('login.view')->with('error', 'Invalid Credentials');
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

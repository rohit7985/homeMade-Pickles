<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SetMerchantPasswordMail;
use App\Models\merchant;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class MerchantRegistrationController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate form inputs
            $validatedData = $request->validate([
                'shopName' => 'required|string',
                'email' => 'required|email|unique:merchants,email',
                // Add more validation rules as needed
            ]);
            // Send email
            Mail::to($validatedData['email'])->send(new SetMerchantPasswordMail());
            // Create a new Merchant
            $merchant = merchant::create([
                'shopName' => $validatedData['shopName'],
                'email' => $validatedData['email'],
            ]);
            return redirect()->route('login.merchant')->with('success', 'Link Sent');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Please Enter the valid email id');
        }
    }

    public function loginViaGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {
        try{
            $merchant =  Socialite::driver('google')->user();
            $findUser = merchant::where('email',$merchant->email)->first();
            if($findUser){
                Auth::guard('merchant')->login($findUser);
                return redirect()->route('merchant.dashboard');
            }else{
                $merchant = merchant::create([
                    'google_id' => $merchant->id,
                    'email' => $merchant->email,
                    'shopName' => 'Shop',
                ]);
                Auth::guard('merchant')->login($merchant);
                return redirect()->route('merchant.dashboard');
            }
        }catch(Exception $e){
            dd($e);
        }
    }

    public function showSetPasswordForm($email)
    {
        return view('merchant.setPassword', ['email' => $email]);
    }
    public function savePassword(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:merchants,email',
                'password' => 'required|min:8|confirmed',
            ]);

            // If validation fails, redirect back with errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $credentials = $request->only('email', 'password');

            // Find the merchant by email
            $merchant = merchant::where('email', $credentials['email'])->first();
            if (!$merchant) {
                return redirect()->back()->with('error', 'User not found with this email!');
            }

            // Hash the password
            $merchant->password = Hash::make($request->password);
            $merchant->save();

            // Attempt authentication
            if (Auth::guard('merchant')->attempt($credentials)) {
                return redirect('/merchant/dashboard');
            } else {
                return back()->withInput($request->only('email'))->withErrors([
                    'email' => 'Invalid email or password',
                ]);
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}

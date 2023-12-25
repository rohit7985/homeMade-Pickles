<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function adminLogin(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect('/admin/dashboard');
            } else {
                return back()->withInput($request->only('email'))->withErrors([
                    'email' => 'Invalid email or Password',
                ]);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Create a new admin
            $admin = Admin::create([
                'name' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Optionally, log in the admin after registration
            // Auth::guard('admin')->login($admin);

            return redirect('/admin/login')->with('success', 'Registration successful! Please login.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function logout()
    {
        try {
            Auth::guard('admin')->logout();
            return redirect('/admin/login');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

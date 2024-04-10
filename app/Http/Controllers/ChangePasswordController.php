<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class ChangePasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            // Generate a unique token for password reset
            $token = Str::random(60);

            // Update the user's password reset token and token expiry
            $user = User::where('email', $request->email)->first();
            $user->password_reset_token = $token;
            $user->password_reset_token_expires_at = now()->addMinutes(5); // Expiry time 5 minutes
            $user->save();

            // Generate the reset link
            $resetLink = route('password.change', ['token' => $token]);

            // Send the password reset email
            Mail::to($request->email)->send(new ResetPasswordMail($resetLink));

            // Return success response
            return redirect()->route('home')->with('success', 'Password reset link sent successfully');
        } catch (ValidationException $e) {
            return redirect()->route('home')->with('error', 'Failed to reset password. ' . $e->getMessage());
        } catch (\Exception $e) {
            dd($e);
            // Handle other exceptions
            return response()->json(['message' => 'Failed to send reset link. Please try again later.'], 500);
        }
    }

    public function showChangeForm(Request $request, $token)
    {
        // Find the user by token
        $user = User::where('password_reset_token', $request->token)
            ->where('password_reset_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('login.view')->with('error', 'Invalid or expired token');
        }
        return view('auth.passwords.changePass', compact('token'));
    }

    public function updatePassword(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'password' => 'required|min:8|confirmed',
            ], [
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 8 characters.',
                'password.confirmed' => 'The password confirmation does not match.'
            ]);

            // Find the user by token
            $user = User::where('password_reset_token', $request->token)
                ->where('password_reset_token_expires_at', '>', now())
                ->first();

            if (!$user) {
                return back()->with('error', 'Invalid or expired token');
            }

            // Reset user's password
            $user->password = Hash::make($validatedData['password']);
            $user->password_reset_token = null;
            $user->password_reset_token_expires_at = null;
            $user->save();

            // Redirect the user after password reset
            return redirect()->route('login')->with('success', 'Password reset successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('error', 'Failed to reset password. Please try again later.');
        }
    }
}

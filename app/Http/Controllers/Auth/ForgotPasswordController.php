<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{

    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        try {
            $request->validate(['email' => 'required|email']);

            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
            $link = Password::RESET_LINK_SENT;
            dd($response, $link);
            
            if ($response == Password::RESET_LINK_SENT) {
                return redirect()->route('login.view')->with('success', 'Password reset link sent successfully');
            } else {
                return redirect()->route('login.view')->with('error', 'Failed to send reset link');
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('login.view')->with('error', 'An unexpected error occurred');
        }
    }

    protected function broker()
    {
        return Password::broker();
    }
}

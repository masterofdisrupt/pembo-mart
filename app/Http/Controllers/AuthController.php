<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use App\Http\Requests\ResetPassword;
use Session;
use Mail;
use Auth;
use Hash;
use Str;

class AuthController
{
    public function showLogin()
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // Define user type redirections
            $redirects = [
                'admin' => 'admin/dashboard',
                'agent' => 'agent/dashboard',
                'user' => 'user/dashboard',
            ];

            $user = Auth::user();

            //     // Redirect based on the user's user_type
            return isset($redirects[$user->role])
                ? redirect()->intended($redirects[$user->role])
                : redirect()->back()->with('error', 'You are already logged in. Redirecting based on your role...".');
        }

        // If not authenticated, return the login view
        return view('auth.login');
    }



    public function authLogin(Request $request)
    {
        // Validate input
        $request->validate([
            'login' => 'required|string', // Email, Username, or Phone
            'password' => 'required|string|min:6',
        ]);

        // Determine if the user wants to be remembered
        $remember = !empty($request->remember);

        // Define redirection paths based on user roles
        $redirects = [
            'admin' => 'admin/dashboard',
            'agent' => 'agent/dashboard',
            'user' => 'user/dashboard',
        ];

        // Authentication attempts with different credentials
        $loginFields = ['email', 'username', 'phone'];
        foreach ($loginFields as $field) {
            $credentials = [
                $field => $request->login,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $remember)) {
                // Get the authenticated user
                $user = Auth::user();

                // Redirect based on the user's role
                return isset($redirects[$user->role])
                    ? redirect()->intended($redirects[$user->role])
                    : redirect()->back()->with('error', 'User role is not defined for redirection.');
            }
        }

        // Authentication failed
        return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
    }

    public function forgot(Request $request)
    {
        return view('auth.forgot');
    }

    public function forgotPassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if ($user) {
            // Generate a secure reset token
            $user->remember_token = Str::random(30);
            $user->password_reset_expires = now()->addMinutes(60); // Optional: Token expiry time
            $user->save();

            try {
                // Send the password reset email
                Mail::to($user->email)->send(new ForgotPasswordMail($user));
                return redirect()->back()->with('success', "If the email exists, you will receive a reset link shortly.");
            } catch (\Exception $e) {
                // Handle email send failure
                return redirect()->back()->with('error', "Failed to send email. Please try again later.");
            }
        }

        // Return a generic success message for security
        return redirect()->back()->with('success', "If the email exists, you will receive a reset link shortly.");
    }

    public function reset($remember_token)
    {
        // Fetch user associated with the provided token
        $user = User::getTokenSingle($remember_token);

        // Check if user exists
        if ($user) {
            // Pass user data to the reset view
            return view('auth.reset', ['user' => $user]);
        }

        // If user does not exist, abort with 404
        return abort(404);
    }

    //
    public function postReset($token, Request $request)
    {
        // Validate the input fields
        $request->validate([
            'password' => 'required|min:8|confirmed', // Checks password and password_confirmation match
        ]);

        // Fetch user based on the token
        $user = User::getTokenSingle($token);
        if (!$user) {
            // Redirect if the token is invalid or user not found
            return redirect()->back()->with('error', "Invalid or expired reset token.");
        }

        // Update the user's password and reset the remember token
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(30); // Generate a new token
        $user->save();

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', "Password successfully reset");
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function set_new_password($token)
    {
        $data['token'] = $token;
        return view('auth.reset_password', $data);
    }

    public function new_password_store($token, ResetPassword $request)
    {
        // Find the user by token or return 404
        $user = User::where('remember_token', $token)->firstOrFail();

        // Update password
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(50); // Regenerate token
        $user->status = 'active'; // Ensure account is active
        $user->save();

        // Ensure user is logged out before redirecting to login
        Auth::logout();
        Session::flush();

        // Redirect user to login page with success message
        return redirect(route('show.login'))->with('success', 'New Password Successfully Set. Please login.');
    }



}

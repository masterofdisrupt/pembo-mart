<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use App\Mail\ForgotAuthPasswordMail;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegisterMail;
use App\Models\User;
use Session;
use Mail;
use Auth;
use Hash;
use Str;

class AuthController
{
    public function showLogin()
    {
        if (Auth::check()) {
            $redirects = [
                'admin' => 'admin/dashboard',
                'agent' => 'agent/dashboard',
                'user' => 'user/dashboard',
            ];

            $user = Auth::user();

            return isset($redirects[$user->role])
                ? redirect()->intended($redirects[$user->role])
                : redirect()->back()->with('error', 'You are already logged in. Redirecting based on your role...".');
        }

        return view('auth.login');
    }



    public function authLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $remember = !empty($request->remember);

        $redirects = [
            'admin' => 'admin/dashboard',
            'agent' => 'agent/dashboard',
            'user' => 'user/dashboard',
        ];

        $loginFields = ['email', 'username', 'phone'];
        foreach ($loginFields as $field) {
            $credentials = [
                $field => $request->login,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();

                return isset($redirects[$user->role])
                    ? redirect()->intended($redirects[$user->role])
                    : redirect()->back()->with('error', 'User role is not defined for redirection.');
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
    }

    public function forgot(Request $request)
    {
        return view('auth.forgot');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([

            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if ($user) {
            $user->remember_token = Str::random(30);
            $user->password_reset_expires = now()->addMinutes(60);
            $user->save();

        
                Mail::to($user->email)->send(new ForgotPasswordMail($user));
                return redirect()->back()->with('success', "If the email exists, you will receive a reset link shortly.");
            }

        return redirect()->back()->with('success', "If the email exists, you will receive a reset link shortly.");
    }

    public function reset($remember_token)
    {

        $user = User::getTokenSingle($remember_token);

        if ($user) {
            return view('auth.reset', ['user' => $user]);
        }

        return abort(404);
    }

    public function postReset($token, Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/|confirmed', // Checks password and password_confirmation match
        ]);

        $user = User::getTokenSingle($token);
        if (!$user) {
            return redirect()->back()->with('error', "Invalid or expired reset token.");
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(30); 
        $user->save();

        return redirect()->route('login')->with('success', "Password successfully reset");
    }

   public function logout(Request $request)
{
    $user = Auth::user();
    $previousUrl = url()->previous();

    $isAdminOrAgent = str_contains($previousUrl, '/admin') || str_contains($previousUrl, '/agent');

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($isAdminOrAgent && $user && in_array($user->role, ['admin', 'agent'])) {
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    return redirect('/')->with('success', 'You have been logged out successfully.');
}


    public function set_new_password($token)
    {
        $data['token'] = $token;
        return view('auth.reset_password', $data);
    }

    public function new_password_store($token, ResetPassword $request)
    {
        $user = User::where('remember_token', $token)->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(50); 
        $user->status = 'active'; 
        $user->save();

        Auth::logout();
        Session::flush();

        return redirect(route('show.login'))->with('success', 'New Password Successfully Set. Please login.');
    }

    public function showSignin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = (bool) $request->is_remember;

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'active',
            'is_delete' => 0,
        ], $remember)) {
            $user = Auth::user();

            if (!empty($user->email_verified_at)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful.',
                    'redirect_url' => $request->input('redirect_url', route('home')),

                ]);
            } else {
                if (empty($user->email_verification_sent_at) || $user->email_verification_sent_at->diffInMinutes(now()) >= 5) {
                    Mail::to($user->email)->send(new RegisterMail($user));
                    $user->email_verification_sent_at = now();
                    $user->save();
                }

                Auth::logout();
                Session::flush();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Email not verified. Please check your email for verification.',
                ])->setStatusCode(403);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials. Please try again.',
            ])->setStatusCode(401);
        }
    }


    public function showRegister(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'surname' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            'confirmed',
        ],
    ], [
        'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ]);

    $checkEmail = User::checkemail($request->email);

    if (!$checkEmail) {
        $user = User::create([
            'name' => trim($request->name),
            'middle_name' => trim($request->middle_name),
            'surname' => trim($request->surname),
            'email' => trim($request->email),
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            Mail::to($user->email)->send(new RegisterMail($user));

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully. Please check your email for verification.',
            ], 201);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to register user.',
        ], 500);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Email already exists.',
    ], 409);
}


public function activateEmail($id)
{
    $id = base64_decode($id);
    $user = User::getSingle($id);

    if ($user) {
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('home')->with('success', 'Email successfully verified. You can now login.');
    }

    return redirect()->route('home')->with('error', 'Invalid or expired verification link.');
}

    public function forgot_password()
    {
        $metaData = [
            'meta_title' => 'Forgot Password',
            'meta_description' => 'Reset your password',
            'meta_keywords' => 'password, reset, forgot password',
        ];
        return view('auth.forgot_password', [
            'meta_title' => $metaData['meta_title'],
        ]);
    }

    public function forgot_password_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::where('email', strtolower($request->email))->first();

        if ($user) {
            $user->remember_token = Str::random(30);
            $user->password_reset_expires = now()->addMinutes(60);
            $user->save();

                Mail::to($user->email)->send(new ForgotAuthPasswordMail($user));
                return redirect()->back()->with('success', "If the email exists, you will receive a reset link shortly.");
            }

        return redirect()->back()->with('error', "If the email exists, you will receive a reset link shortly.");
    }

    public function reset_password($remember_token)
    {
        $user = User::getTokenSingle($remember_token);

        if ($user) {
            return view('auth.password_reset', ['user' => $user]);
        }

        return abort(404);
    }

    public function reset_password_post($token, Request $request)
    {
        $request->validate([
            'password' => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            'confirmed',
        ],
    ], [
        'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ]);

        $user = User::getTokenSingle($token);
        if (!$user) {
            return redirect()->back()->with('error', "Invalid or expired reset token.");
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(30); 
        $user->save();

        return redirect()->route('home')->with('success', "Password successfully reset");
    }

}
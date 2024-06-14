<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|min:10|max:20',
            'password' => 'required|string|min:5|confirmed',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to create the user
        try {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "password" => Hash::make($request->password),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }

        // Check if user creation was successful
        if (!$user) {
            return redirect()->back()->with('error', 'Something went wrong')->withInput();
        }

        // Automatically log in the user by setting session
        $request->session()->put('LoggedUser', $user->id);

        // Redirect to the dashboard
        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    // Login
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to find the user
        $user = User::where('email', $request->email)->first();

        // Check if user password match
        if ($user && Hash::check($request->password, $user->password)) {
            // Log in the user by setting session
            $request->session()->put('LoggedUser', $user->id);

            // Redirect to the dashboard
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        // Otherwise return error message
        return redirect()->back()->with('error', 'Invalid credentials')->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        // Check if session has some value
        if (session()->has('LoggedUser')) {
            // Clear the session
            session()->pull('LoggedUser');
        }

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    // forgot password
    public function forgot(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // create recovery token 
        $token = Str::uuid();
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email not found')->withInput();
        }

        // Create mail details
        $details = [
            'body' => url('reset', ['email' => $request->email, 'token' => $token]),
        ];

        // update the user
        $user->token = $token;
        $user->token_expire = Carbon::now()->addMinutes(10)->toDateTimeString();
        $user->save();

        // Send mail
        Mail::to($user->email)->send(new ForgotPassword($details));
        return redirect()->route('login')->with('success', 'Recovery link sent to your email');
    }

    // reset password
    public function reset(Request $request)
    {
        echo $request->token;
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:5|confirmed',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the user by email and token
        $user = User::where('email', $request->email)->where('token', $request->token)->first();

        if (!$user || Carbon::parse($user->token_expire)->isPast()) {
            return redirect()->back()->with('error', 'Invalid or expired token.');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->token = null; // Clear the token
        $user->token_expire = null; // Clear the token expiration
        $user->save();

        return redirect()->route('login')->with('success', 'Password reset successfully!');
    }
}

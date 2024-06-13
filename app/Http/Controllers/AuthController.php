<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
}

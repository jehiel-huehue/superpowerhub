<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function showRegistration()
    {
        return view('auth.register'); // resources/views/auth/login.blade.php
    }

    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        // Validate the credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate the session to avoid session fixation attacks
            $request->session()->regenerate();

            // Check the user's role and redirect accordingly
            $user = Auth::user();

            // If the user is an admin, redirect to the admin dashboard
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // For regular users, redirect to the user dashboard
            return redirect()->intended('/dashboard');
        }

        // If login fails, return with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
{
    // Validate incoming data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user', // default role
    ]);

    return response()->json([
        'message' => 'User registered successfully!',
        'user' => $user
    ]);
}
}
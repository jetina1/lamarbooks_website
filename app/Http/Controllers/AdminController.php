<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // For making HTTP requests

class AdminController extends Controller
{
    //
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function showSigninForm()
    {
        return view('auth.signin');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Send POST request to NestJS backend API to register the user
        $response = Http::post('http://192.168.29.91:3000/signup', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('signin')->with('success', 'Signup successful, please login.');
        } else {
            return back()->withErrors(['error' => 'Signup failed. Please try again.']);
        }
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Send POST request to NestJS backend API to sign in
        $response = Http::post('http://192.168.29.91:3000/signin', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $token = $response->json()['access_token'];
            session(['access_token' => $token]);

            return redirect()->route('dashboard')->with('success', 'Signin successful.');
        } else {
            return back()->withErrors(['error' => 'Signin failed. Please check your credentials.']);
        }
    }
}

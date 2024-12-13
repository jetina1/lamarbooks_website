<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;


class AuthController extends Controller
{

    public function showSignupForm()
    {
        $nodejsBaseUrl = env('NODEJS_BASE_URL');
        return view('auth.signup', compact('nodejsBaseUrl'));
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'hash' => Hash::make($request->password),
                'role' => 'ADMIN',
            ]);

            $token = JWTAuth::fromUser($user);
            return response()->json(['message' => 'Signup successful', 'token' => $token], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Signup failed: ' . $e->getMessage()], 500);
        }
    }

    // {
    //     // Log the Authorization header for debugging
    //     \Log::info($request->header('Authorization'));

    //     // $authHeader = $request->header('Authorization');
    //     // $token = $authHeader ? str_replace('Bearer ', replace: '', $authHeader) : null;

    //     if (!$token) {
    //         return redirect()->route('signin')->withErrors(['error' => 'Authentication required.']);
    //     }

    //     try {
    //         $user = JWTAuth::setToken($token)->authenticate();

    //         return view('dashboard', ['user' => $user, 'token' => $token]);
    //     } catch (Exception $e) {
    //         return redirect()->route('signin')->withErrors(['error' => 'Invalid or expired token.']);
    //     }
    // }

    // public function showAdminPanel(Request $request)
    // {
    //     // Get the JWT from the cookie
    //     $token = $request->cookie('token');

    //     if (!$token) {
    //         return redirect()->route('signin'); // Redirect if no token is found
    //     }

    //     try {
    //         // Decode the JWT (using your secret key)
    //         $decoded = JWT::decode($token, env('JWT_SECRET'), ['HS256']); // Adjust the algorithm as necessary

    //         // Assuming `sub` contains the user ID
    //         $user = User::find($decoded->sub); // Fetch the user by ID from the decoded token

    //         if (!$user) {
    //             return redirect()->route('signin'); // Redirect if user not found
    //         }

    //         return view('admin.panel', compact('user')); // Pass the user to the view

    //     } catch (ExpiredException $e) {
    //         return redirect()->route('signin')->withErrors('Token has expired');
    //     } catch (\Exception $e) {
    //         return redirect()->route('signin')->withErrors('Invalid token');
    //     }
    // }

    public function signin(Request $request)
    {
        // Validate user input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Check if the user exists in the database
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->hash)) {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
        }

        // Generate JWT token
        try {
            $token = JWTAuth::fromUser($user);
        } catch (Exception $e) {
            return response()->json(['error' => 'Token creation failed'], 500);
        }

        // Set the token in an HTTP-only cookie
        $cookie = cookie('jwt_token', $token, 120, '/', null, true, true); // 60 minutes expiration

        // Redirect to the dashboard and attach the cookie
        return redirect('/dashboard')->cookie($cookie);
    }

    public function index(Request $request)
    {
        // Retrieve the authenticated user
        $user = $request->get('auth_user');

        return view('dashboard', [
            'user' => $user,
        ]);
    }
    /**
     * Log out the user by invalidating the JWT token and clearing the cookie.
     */
    public function logout(Request $request)
    {
        try {
            // Retrieve the token from the cookie
            $token = $request->cookie('jwt_token');
            if ($token) {
                JWTAuth::setToken($token)->invalidate();
            }
        } catch (Exception $e) {
            return redirect('/signin')->withErrors(['error' => 'Failed to logout']);
        }

        // Clear the cookie
        return redirect('/signin')->withCookie(cookie()->forget('jwt_token'));
    }
    public function showResetPasswordForm(Request $request)
    {
        $token = $request->route('token'); // Get token from URL
        $email = $request->email; // Optional: Pass email via query
        return view('auth.forgot');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->hash = Hash::make($request->password);
            $user->save();

            return redirect()->route('signin')->with('status', 'Password updated successfully.');
        }

        return back()->withErrors(['email' => 'User not found.']);
    }
    public function editPassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Old password is incorrect'], 403);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function loggout()
    {

        // Clear all session data
        session()->flush();

        // Optionally, regenerate the session ID to avoid session fixation attacks
        session()->regenerate();

        // Redirect to the sign-in page with a success message
        return redirect()->route('signin')->with('message', 'You have been logged out successfully.');

    }
    /**
     * Get authenticated user's data.
     */
    public function getUserData()
    {
        return response()->json(auth()->user());
    }
}




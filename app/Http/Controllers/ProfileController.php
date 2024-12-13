<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Redirect;
// use Illuminate\View\View;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Validator;
// use App\Models\User;
// use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{

    // get user
    // app/Http/Controllers/UserController.php
    public function show()
    {
        // Get the authenticated user
        $user = JWTAuth::parseToken()->authenticate();

        // Pass the user data to the profile view
        return view('profile.edit', compact('user'));
    }
    public function profile(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user, 200);
    }


    public function updateProfile(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Update the name if provided, otherwise keep the existing value
        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        // Update the email if provided, otherwise keep the existing value
        if ($request->filled('email')) {
            $user->email = $request->input('email');
        }

        // Update the password only if a new password is provided
        if ($request->filled('password')) {
            $user->hash = Hash::make($request->input('password'));
        }

        $user->save();

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }
}
// public function addProfile(Request $request)
// {
//     // Validate the request
//     $validator = Validator::make($request->all(), [
//         'user_id' => 'required|exists:users,id', // Ensure user ID exists in the database
//         'name' => 'required|string|max:255',
//         'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image upload
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 400);
//     }

//     try {
//         // Fetch the user based on the provided user ID
//         $user = User::find($request->user_id);

//         if (!$user) {
//             return response()->json(['message' => 'User not found'], 404);
//         }

//         // Update the user's name
//         $user->name = $request->input('name');

//         // Handle profile picture upload if provided
//         if ($request->hasFile('profile_picture')) {
//             // Delete the old profile picture if it exists
//             if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
//                 unlink(public_path($user->profile_picture));
//             }

//             // Define the path for storing profile pictures
//             $destinationPath = 'profile/';
//             $file = $request->file('profile_picture');
//             $fileName = time() . '_' . $file->getClientOriginalName();

//             // Move the file to the public/profile directory
//             $file->move(public_path($destinationPath), $fileName);

//             // Save the relative path in the database
//             $user->profile_picture = $destinationPath . $fileName;
//         }

//         // Save the user's updated information
//         $user->save();

//         return response()->json([
//             'message' => 'Profile updated successfully',
//             'user' => $user,
//         ], 200);
//     } catch (\Exception $e) {
//         return response()->json(['message' => $e->getMessage()], 500);
//     }
// }

// public function profile(Request $request)
// {
//     $token = $request->bearerToken();

//     // Get user data from NestJS backend using the token
//     $response = Http::withToken($token)->get(env('BASE_URI') . '/auth/getuser');

//     if ($response->successful()) {
//         $user = $response->json();
//         return response()->json($user);
//     }

//     return response()->json(['message' => 'Unauthorized'], 401);
// }

/**
 * Display the user's profile form.
 */
// public function edit(Request $request): View
// {
//     return view('profile.edit', [
//         'user' => $request->user(),
//     ]);
// }

/**
 * Update the user's profile information.
 */
// public function update(ProfileUpdateRequest $request): RedirectResponse
// {
//     $request->user()->fill($request->validated());

//     if ($request->user()->isDirty('email')) {
//         $request->user()->email_verified_at = null;
//     }

//     $request->user()->save();

//     return Redirect::route('profile.edit')->with('status', 'profile-updated');
// }

// public function updateProfile(Request $request)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|email',
//         'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     $user = Auth::user();
//     $user->name = $request->name;
//     $user->email = $request->email;

//     // Handle profile image upload
//     if ($request->hasFile('profileImage')) {
//         $imagePath = $request->file('profileImage')->store('profile_images', 'public');
//         $user->profileImage = $imagePath;
//     }

//     $user->save();

//     return redirect()->route('profile')->with('success', 'Profile updated successfully!');
// }


/**
 * Delete the user's account.
 */
// public function destroy(Request $request): RedirectResponse
// {
//     $request->validateWithBag('userDeletion', [
//         'password' => ['required', 'current_password'],
//     ]);

//     $user = $request->user();

//     Auth::logout();

//     $user->delete();

//     $request->session()->invalidate();
//     $request->session()->regenerateToken();

//     return Redirect::to('/');
// }


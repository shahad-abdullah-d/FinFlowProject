<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'unique:users,phone'],
            'gender' => ['nullable', 'in:male,female'],
            'department_id' => ['nullable', 'exists:departments,id'],
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'Registration submitted. Waiting for admin approval.',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
{
    $validated = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials.',
        ], 401);
    }

    if ($user->status === 'pending') {
        return response()->json([
            'message' => 'Your account is pending approval.',
        ], 403);
    }

    if ($user->status === 'rejected') {
        return response()->json([
            'message' => 'Your account has been rejected.',
        ], 403);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful.',
        'user' => $user,
        'token' => $token,
    ]);
}

public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully.',
    ]);
}


}
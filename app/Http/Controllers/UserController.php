<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\validation\validationException;

class UserController extends Controller
{
    public function register (Request $request) {
        $request->validate ([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'private_key' => bin2hex(random_bytes(16)),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login (Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if(! $user || ! Hash::check($request->password, $user->password)) {
            throw validationException::withMessages([
                'email' => ['The provided credentials are incorrect'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

}
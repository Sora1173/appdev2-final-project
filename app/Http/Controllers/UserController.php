<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\validation\validationException;

class UserController extends Controller
{
    public function register (RegisterUserRequest $request) {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'private_key' => bin2hex(random_bytes(16)),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login (LoginUserRequest $request) {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if(! $user || ! Hash::check($validated['password'], $user->password)) {
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
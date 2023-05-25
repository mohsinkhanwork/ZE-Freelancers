<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
        {
            $request->validate([
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),

            ]);

            return response()->json(['message' => 'User registered successfully.', 'user' => $user]);
        }
    public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 401);
            }

            if (!Hash::check($request->input('password'), $user->password)) {
                return response()->json(['message' => 'Incorrect password'], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            unset($user->password);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        }

        public function getUser(Request $request)
            {
                return $request->user();
            }

}

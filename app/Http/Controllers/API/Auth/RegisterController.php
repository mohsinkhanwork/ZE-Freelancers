<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


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

            $user = User::with('userData')->
            where('email', $request->input('email'))->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 401);
            }

            if (!Hash::check($request->input('password'), $user->password)) {
                return response()->json(['message' => 'Incorrect password'], 401);
            }

            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            $cookie = cookie('auth_token', $token, 60); // 60 minutes, is not set for now

            unset($user->password);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        }

        public function linkedin_callback(Request $request)
            {
                $code = $request->input('code');
                $state = $request->input('state');

                // Exchange the authorization code for an access token
                $accessToken = $this->getLinkedInAccessToken($code, $state);

                // Retrieve user data from LinkedIn using the access token
                $userData = $this->getLinkedInUserData($accessToken);

                // Create a new user or login with the retrieved data
                $user = $this->registerOrLoginWithLinkedIn($userData);

                // Generate an authentication token for the user
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ]);
            }

    private function getLinkedInAccessToken($code, $state)
    {
        $clientId = '77qpmgymtgu6hy';
        $clientSecret = 'dpjFfgNplIDtHCjf';
        $redirectUri = 'http://localhost:8080/callback';

        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);

        // dd($response->json());

        return $response['access_token'];
    }

    private function getLinkedInUserData($accessToken)
        {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $accessToken",
                'Accept' => 'application/json',
            ])->get('https://api.linkedin.com/v2/me');

            $emailResponse = Http::withHeaders([
                'Authorization' => "Bearer $accessToken",
                'Accept' => 'application/json',
            ])->get('https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))');

            $userData = $response->json();
            $emailData = $emailResponse->json();

            // Add email to the userData array
            $userData['email'] = $emailData['elements'][0]['handle~']['emailAddress'];

            return $userData;
        }


    private function registerOrLoginWithLinkedIn($userData)
    {
        // Check if the user already exists based on LinkedIn data
        $user = User::where('linkedin_id', $userData['id'])->first();

        if (!$user) {
            // Create a new user
            $user = User::create([
                'name' => $userData['localizedFirstName'],
                'email' => $userData['email'],
                'linkedin_id' => $userData['id'],
                'password' => Hash::make(Str::random(16)),
                // Add other necessary fields based on your user model
            ]);
        }

        return $user;
    }
}

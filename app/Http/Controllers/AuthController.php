<?php

namespace App\Http\Controllers;

use App\Http\Helper\RandomStringGenerator;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): Response
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'invitation_link' => RandomStringGenerator::generate(20),
        ]);

        $token = $user->createToken('appToken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function logout(Request $request): Response
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logged out',
        ], 200);
    }

    public function login(LoginRequest $request): Response
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if (!$user instanceof User || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }
        $user->tokens()->each(function($token) {
            $token->delete();
        });

        $token = $user->createToken('appToken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}

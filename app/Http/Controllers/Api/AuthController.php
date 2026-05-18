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
        $data = $request->validate(['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required|min:8']);
        $user = User::create($data + ['role' => 'client']);
        return response()->json(['user' => $user, 'token' => $user->createToken('api')->plainTextToken], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required']);
        $user = User::whereEmail($data['email'])->first();
        abort_unless($user && Hash::check($data['password'], $user->password), 422, 'Identifiants invalides.');
        return response()->json(['user' => $user, 'token' => $user->createToken('api')->plainTextToken]);
    }
}

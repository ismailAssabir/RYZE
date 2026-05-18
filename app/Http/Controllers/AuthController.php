<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login() { return view('auth.login'); }
    public function register() { return view('auth.register'); }
    public function forgot() { return view('auth.forgot-password'); }

    public function storeRegister(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:120', 'email' => 'required|email|unique:users,email', 'password' => 'required|confirmed|min:8']);
        $user = User::create($data + ['role' => 'client']);
        Auth::login($user, true);
        return redirect()->route('dashboard');
    }

    public function storeLogin(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors(['email' => 'Identifiants invalides.']);
    }

    public function sendReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        Password::sendResetLink($request->only('email'));
        return back()->with('success', 'Lien de reinitialisation envoye si le compte existe.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}

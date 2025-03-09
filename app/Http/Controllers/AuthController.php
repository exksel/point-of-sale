<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:users,phone_number',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6'
        ]);

        User::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    // LOGOUT
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login'); // Arahkan ke halaman landing.home
}

}

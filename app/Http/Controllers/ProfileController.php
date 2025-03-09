<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile', compact('user')); // Menampilkan data user ke view
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'username' => 'required|string|max:50',
            'password' => 'nullable|min:6',
        ]);

        // Cek apakah password diubah sebelum menyimpan
        $passwordChanged = $request->filled('password');

        // Update data
        $user->full_name = $request->full_name;
        $user->phone_number = $request->phone_number;
        $user->username = $request->username;

        if ($passwordChanged) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Logout jika password diubah
        if ($passwordChanged) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}


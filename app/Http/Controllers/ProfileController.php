<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman detail profil (Read Only)
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        // Contoh pengecekan role jika ingin membedakan data yang dikirim
        if ($user->role === 'admin') {
            // Logika tambahan khusus admin (jika ada)
            // misal: $data = AdminLog::latest()->get();
        }

        return view('profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * Tampilkan form edit profile
     */
    public function edit(Request $request): View
    {
        // Cek role untuk memastikan admin/user mendapatkan view yang benar 
        // (meskipun layout sudah diatur di blade, ini untuk jaga-jaga)
        $user = $request->user();

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update profile (nama & email)
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Cek role untuk menentukan arah redirect setelah sukses
        if ($user->role === 'admin') {
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        // Cek role jika ingin memberikan pesan sukses yang berbeda
        $message = $request->user()->role === 'admin' 
            ? 'Password Administrator berhasil diperbarui!' 
            : 'Password Anda berhasil diperbarui!';

        return back()->with('status', 'password-updated')->with('message', $message);
    }
}
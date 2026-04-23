<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $token = \Illuminate\Support\Str::random(64);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => \App\Models\User::ROLE_WARGA,
            'is_active' => false,
            'activation_token' => $token,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        // Send Welcome & Activation Email
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\DynamicMailable(
                'Aktivasi Akun Anda - ' . \App\Models\SiteMeta::getVal('village_name', 'Portal Desa'),
                'view:emails.register',
                [
                    'name' => $user->name,
                    'village_name' => \App\Models\SiteMeta::getVal('village_name', 'Portal Desa'),
                    'url' => route('register.activate', ['token' => $token])
                ]
            ));
        } catch (\Exception $e) {
            \Log::error("Failed to send registration email to {$user->email}: " . $e->getMessage());
        }

        return redirect()->route('login')->with('success', 'Akun Anda berhasil dibuat! Silakan cek email Anda untuk mengaktifkan akun.');
    }

    public function activate($token)
    {
        $user = \App\Models\User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Token aktivasi tidak valid atau sudah kedaluwarsa.');
        }

        $user->is_active = true;
        $user->activation_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Akun Anda telah berhasil diaktifkan! Silakan masuk.');
    }

    public function resendActivation(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || $user->is_active) {
            return back()->with('info', 'Jika email terdaftar dan belum aktif, instruksi baru telah dikirim.');
        }

        $token = \Illuminate\Support\Str::random(64);
        $user->activation_token = $token;
        $user->save();

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\DynamicMailable(
                'Kirim Ulang Aktivasi Akun - ' . \App\Models\SiteMeta::getVal('village_name', 'Portal Desa'),
                'view:emails.register',
                [
                    'name' => $user->name,
                    'village_name' => \App\Models\SiteMeta::getVal('village_name', 'Portal Desa'),
                    'url' => route('register.activate', ['token' => $token])
                ]
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba sesaat lagi.');
        }

        return back()->with('success', 'Email aktivasi baru telah dikirim ke alamat email Anda.');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->with('error', 'Akun Anda belum aktif. Silakan cek email untuk aktivasi atau klik tautan di bawah untuk kirim ulang.')->with('needs_activation', true)->with('pending_email', $request->email);
            }

            $request->session()->regenerate();

            if ($user->isAdmin() || $user->isAparatur()) {
                return redirect()->intended('admin');
            }

            return redirect()->intended('resident/dashboard');
        }

        return back()->withErrors([
            'email' => 'Informasi akun yang Anda masukkan tidak terdaftar.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

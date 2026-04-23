<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Mail\DynamicMailable;
use App\Models\SiteMeta;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('admin')->with('error', 'Hanya Admin yang dapat mengelola pengguna.');
        }

        $query = User::query();

        if ($request->has('role') && in_array($request->role, ['admin', 'aparatur', 'warga'])) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Hanya Admin yang dapat menambah aparat.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:aparatur,admin',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'is_active' => true, // Manually added users are active by default
        ]);

        return back()->with('success', 'User ' . $request->role . ' berhasil ditambahkan.');
    }

    public function toggleActive(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Hanya Admin yang dapat mengubah status pengguna.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        if ($user->is_active) {
            // Send activation email using themed view
            $subject = SiteMeta::getVal('email_activation_subject', 'Akun Anda Telah Aktif!');
            
            try {
                Mail::to($user->email)->send(new DynamicMailable($subject, 'view:emails.activation', [
                    'name' => $user->name,
                    'email' => $user->email,
                    'url' => route('login'),
                    'village_name' => SiteMeta::getVal('village_name', 'Portal Desa')
                ]));
            } catch (\Exception $e) {
                return back()->with('success', "Akun diaktifkan, namun Gagal kirim email: " . $e->getMessage());
            }
        }

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Hanya Admin yang dapat menghapus pengguna.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}

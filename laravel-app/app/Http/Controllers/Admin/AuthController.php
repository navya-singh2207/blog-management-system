<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->session()->has('admin_id')) {
            return redirect()->route('admin.blogs.index');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::query()->where('email', $data['email'])->first();
        if (!$admin || !Hash::check($data['password'], $admin->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid credentials.');
        }

        $request->session()->regenerate();
        $request->session()->put('admin_id', $admin->id);

        return redirect()->route('admin.blogs.index')->with('success', 'Welcome back.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logged out.');
    }
}


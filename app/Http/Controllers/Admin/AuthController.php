<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember-me');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.settings.index'));
        }

        return back()->withErrors([
            'user_id' => '제공된 자격 증명이 기록과 일치하지 않습니다.',
        ])->onlyInput('user_id');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($request->login === 'admin@gmail.com' &&
            md5($request->password) === "d8578edf8458ce06fbc5bb76a58c5ca4"
        )
            {
            $request->session()->put('isAdmin', 1);
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput($request->only('login'))
            ->withErrors(['login' => 'Неверные учетные данные']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('isAdmin');
        return redirect()->route('admin.login');
    }
} 
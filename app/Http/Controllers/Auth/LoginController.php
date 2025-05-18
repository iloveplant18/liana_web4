<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['user_id' => $user->id, 'user_name' => $user->full_name]);
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные',
        ]);
    }

    public function logout()
    {
        session()->forget(['user_id', 'user_name']);
        return redirect()->route('home');
    }
}

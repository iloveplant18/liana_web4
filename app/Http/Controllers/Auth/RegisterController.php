<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'full_name' => $request->first_name . ' ' . $request->last_name,
            'name' => $request->first_name,
            'email' => $request->email,
            'login' => $request->login,
            'password' => Hash::make($request->password),
        ]);

        session(['user_id' => $user->id, 'user_name' => $user->full_name]);

        return redirect()->route('home');
    }

    function checkIsLoginAvailable(Request $request) {
        $request->validate([
            "login" => "required|string",
        ]);

        $usersWithGivenLogin = User::where("login", $request->login)->limit(1)->get();

        if ($usersWithGivenLogin->count()) {
            return [
                "isAvailable" => false,
            ];
        }

        return [
            "isAvailable" => true,
        ];
    }
} 

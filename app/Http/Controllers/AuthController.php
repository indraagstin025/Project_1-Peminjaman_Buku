<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'unique:' . User::class],
            'address' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'numeric'],
            'gender' => ['required', Rule::in(['Man', 'Woman'])],
            'password' => ['required', 'string', 'confirmed', 'max:255'],
        ]);

        $credentials['role'] = 'Member';
        $credentials['password'] = Hash::make($credentials['password']);

        $user = User::create($credentials);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
    
        $user = User::where('username', $credentials['username'])->first();
    
        if (!$user) {
            // Username tidak valid
            return back()->with('login_error', 'Username anda tidak valid.')->onlyInput('username');
        }
    
        // Memastikan username yang dimasukkan sesuai dengan yang disimpan di database
        if ($user->username !== $credentials['username']) {
            return back()->with('login_error', 'Username anda tidak valid.')->onlyInput('username');
        }
    
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            // Password tidak valid
            return back()->with('login_error', 'Password anda tidak valid.')->onlyInput('username');
        }
    
        $request->session()->regenerate();
    
        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller {
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function showRegister() {
        $roles = Role::whereNotIn('role_name',['Admin'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request) {
        $data = $request->validate([
            'full_name'=>'required|string|max:100',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:6',
            'role_id'=>'required|exists:roles,role_id',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        if ($user->role->role_name === 'Client') {
            Client::create(['user_id' => $user->user_id]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}

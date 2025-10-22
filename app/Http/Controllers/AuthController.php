<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Role;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller {
    public function showLogin() {
        if(Auth::id() != null){
            return $this->redirectByRole(Auth::user());
        }
        
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is inactive. Please contact an administrator.']);
            }

            $request->session()->regenerate();

            AuditLog::create([
                'user_id' => $user->user_id,
                'action' => 'login',
                'target_table' => 'users',
                'target_id' => $user->user_id,
                'remarks' => $user->full_name . ' logged in to the system.',
            ]);

            return $this->redirectByRole($user);
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function showRegister()
    {
        if(Auth::id() != null){
            return $this->redirectByRole(Auth::user());
        }
        
        $roles = Role::whereNotIn('role_name', ['Admin'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role_id' => 'required|exists:roles,role_id',
        ]);

        $data['status'] = 'active';
        $user = User::create($data);

        if (strtolower($user->role->role_name) === 'client') {
            Client::create([
                'user_id' => $user->user_id,
                'current_job' => null,
                'financing_type' => null,
            ]);
        }

        Auth::login($user);

        AuditLog::create([
            'user_id' => $user->user_id,
            'action' => 'register',
            'target_table' => 'users',
            'target_id' => $user->user_id,
            'remarks' => 'New user registration: ' . $user->full_name,
        ]);

        return $this->redirectByRole($user);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            AuditLog::create([
                'user_id' => $user->user_id,
                'action' => 'logout',
                'target_table' => 'users',
                'target_id' => $user->user_id,
                'remarks' => $user->full_name . ' logged out.',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function redirectByRole(User $user)
    {
        // $roleName = strtolower($user->role->role_name);

        // return match ($roleName) {
        //     'admin' => redirect()->route('dashboard.admin'),
        //     'sales manager' => redirect()->route('dashboard.manager'),
        //     'agent' => redirect()->route('dashboard.agent'),
        //     'client' => redirect()->route('dashboard.client'),
        //     default => redirect('/dashboard'),
        // };
        return redirect()->route('dashboard');
    }
}

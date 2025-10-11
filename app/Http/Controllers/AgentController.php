<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AgentController extends Controller {
    public function index() {
        $agents = User::whereHas('role', function($q){
            $q->where('role_name','Agent');
        })->paginate(20);

        return view('agents.index', compact('agents'));
    }

    public function show(User $agent) {
        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        return view('agents.show', compact('agent'));
    }

    public function create() {
        $roles = Role::where('role_name', 'Agent')->get();
        return view('agents.create', compact('roles'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

    public function edit(User $agent) {
        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        $roles = Role::where('role_name', 'Agent')->get();
        return view('agents.edit', compact('agent', 'roles'));
    }
    public function update(Request $request, User $agent) {
        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$agent->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        $agent->name = $request->name;
        $agent->email = $request->email;
        if ($request->filled('password')) {
            $agent->password = bcrypt($request->password);
        }
        $agent->role_id = $request->role_id;
        $agent->save();

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(User $agent) {
        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }
}

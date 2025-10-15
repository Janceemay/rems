<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller {
    public function index()
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $agents = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))
            ->withCount(['transactions', 'commissions'])
            ->paginate(20);

        return view('agents.index', compact('agents'));
    }

    public function show(User $agent) {
        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        $agent->load(['propertiesAssigned', 'transactions.property', 'commissions']);

        return view('agents.show', compact('agent'));
    }

    public function create() {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $role = Role::where('role_name', 'Agent')->first();

        return view('agents.create', compact('role'));
    }

    public function store(Request $request){
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'contact_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'age' => 'nullable|integer|min:18|max:65',
        ]);

        $agentRole = Role::where('role_name', 'Agent')->first();

        $user = User::create([
            'role_id' => $agentRole->role_id,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'contact_number' => $data['contact_number'] ?? null,
            'gender' => $data['gender'] ?? null,
            'age' => $data['age'] ?? null,
            'status' => 'active',
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'users',
            'target_id' => $user->user_id,
            'remarks' => "New Agent '{$user->full_name}' created by " . Auth::user()->full_name,
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

    public function edit(User $agent) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, User $agent) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $agent->user_id . ',user_id',
            'password' => 'nullable|string|min:8|confirmed',
            'contact_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'age' => 'nullable|integer|min:18|max:65',
            'status' => 'required|string|max:20',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $agent->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'users',
            'target_id' => $agent->user_id,
            'remarks' => "Agent '{$agent->full_name}' profile updated by " . Auth::user()->full_name,
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(User $agent) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if ($agent->role->role_name !== 'Agent') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        $agentName = $agent->full_name;
        $agent->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'users',
            'target_id' => $agent->user_id,
            'remarks' => "Agent '{$agentName}' deleted by " . Auth::user()->full_name,
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

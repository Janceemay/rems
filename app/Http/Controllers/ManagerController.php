<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Agent;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller {
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

    public function profile()
    {
        $user = Auth::user();

        if (!$user->isRole('Sales Manager')) {
            abort(403, 'Unauthorized access.');
        }

        return view('profiles.manager', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:11',
            'age' => 'required|integer',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = '/storage/' . $path;
        }

        $user->contact_number = $request->phone;
        $user->age = $request->age;
        $user->full_name = $request->name;
        $user->save();

        AuditLog::create([
            'user_id' => $user->user_id,
            'action' => 'update',
            'target_table' => 'users',
            'target_id' => $user->user_id,
            'remarks' => "Your profile is successfully updated",
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function create()
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $role = Role::where('role_name', 'Agent')->first();
        $manager = Auth::user(); 

        return view('agents.create', compact('role', 'manager'));
    }


    public function store(Request $request)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'contact_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'age' => 'nullable|integer|min:18|max:65',
        ]);

        $manager = Auth::user();
        $agentRole = Role::where('role_name', 'Sales Manager')->first();

        $defaultPassword = 'helloworld123';

        $user = User::create([
            'role_id' => $agentRole->role_id, 
            'manager_id' => $manager->user_id,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $defaultPassword,
            'contact_number' => $data['contact_number'] ?? null,
            'gender' => $data['gender'] ?? null,
            'age' => $data['age'] ?? null,
            'status' => 'active',
        ]);

        //remember to use model agents
        $agent = Agent::create([
            'user_id' => $user->user_id,
            'rank' => '',
            'contact_no' => $user->contact_number,
            'email' => $user->email,
            'team_id' => null,
            'manager_id' => $manager->user_id,
            'remarks' => null,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'users',
            'target_id' => $user->user_id,
            'remarks' => "New Agent '{$user->full_name}' created by " . Auth::user()->full_name,
        ]);

        return redirect()->route('dashboard.manager')->with('success', "Agent created successfully. Default password is 'helloworld123'.");
    }

    public function edit(User $agent) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if ($agent->role->role_name !== 'Manager') {
            return redirect()->route('agents.index')->with('error', 'User is not an agent.');
        }

        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, User $agent) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if ($agent->role->role_name !== 'Sales Manager') {
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

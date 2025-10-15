<?php

namespace App\Http\Controllers;

use App\Models\Quota;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotaController extends Controller {
    public function index() {
        $user = Auth::user();
        $role = optional($user->role)->role_name;

        if (in_array($role, ['Admin', 'Sales Manager'])) {
            $quotas = Quota::with('manager')->latest()->paginate(20);
        } elseif ($role === 'Agent') {
            $quotas = Quota::where('agent_id', $user->user_id)->paginate(20);
        } else {
            abort(403, 'Unauthorized access.');
        }

        return view('quotas.index', compact('quotas'));
    }

    public function create() {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $agents = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('quotas.create', compact('agents'));
    }

    public function store(Request $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'manager_id' => 'required|exists:users,user_id',
            'agent_id' => 'nullable|exists:users,user_id',
            'target_sales' => 'required|numeric|min:0',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
        ]);

        $quota = Quota::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'quotas',
            'target_id' => $quota->quota_id,
            'remarks' => "Quota assigned to Agent ID {$quota->agent_id}",
        ]);

        return redirect()->route('quotas.index')->with('success', 'Quota created successfully.');
    }

    public function edit(Quota $quota) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        return view('quotas.edit', compact('quota'));
    }

    public function update(Request $request, Quota $quota) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'target_sales' => 'required|numeric|min:0',
            'achieved_sales' => 'nullable|numeric|min:0',
            'status' => 'nullable|string',
        ]);

        $quota->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'quotas',
            'target_id' => $quota->quota_id,
            'remarks' => 'Quota updated',
        ]);

        return redirect()->route('quotas.index')->with('success', 'Quota updated successfully.');
    }

    public function destroy(Quota $quota) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $quota->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'quotas',
            'target_id' => $quota->quota_id,
            'remarks' => 'Quota deleted',
        ]);

        return redirect()->route('quotas.index')->with('success', 'Quota deleted.');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

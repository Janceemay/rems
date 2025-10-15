<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller {
    public function index() {
        $teams = Team::with('manager')->paginate(20);
        return view('teams.index', compact('teams'));
    }

    public function show(Team $team) {
        $team->load('manager', 'agents');
        return view('teams.show', compact('team'));
    }

    public function create() {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $managers = User::whereHas('role', fn($q) => $q->where('role_name', 'Sales Manager'))->get();
        return view('teams.create', compact('managers'));
    }

    public function store(Request $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'manager_id' => 'required|exists:users,user_id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $team = Team::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'teams',
            'target_id' => $team->team_id,
            'remarks' => "Team {$team->name} created under Manager ID {$team->manager_id}",
        ]);

        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    public function assignAgent(Request $request, Team $team) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'agent_id' => 'required|exists:users,user_id',
        ]);

        $team->agents()->attach($data['agent_id']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'assign',
            'target_table' => 'teams',
            'target_id' => $team->team_id,
            'remarks' => "Agent ID {$data['agent_id']} assigned to Team {$team->name}",
        ]);

        return back()->with('success', 'Agent assigned successfully.');
    }

    public function removeAgent(Request $request, Team $team) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'agent_id' => 'required|exists:users,user_id',
        ]);

        $team->agents()->detach($data['agent_id']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'remove',
            'target_table' => 'teams',
            'target_id' => $team->team_id,
            'remarks' => "Agent ID {$data['agent_id']} removed from Team {$team->name}",
        ]);

        return back()->with('success', 'Agent removed successfully.');
    }

    public function destroy(Team $team) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $team->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'teams',
            'target_id' => $team->team_id,
            'remarks' => "Team {$team->name} deleted",
        ]);

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully.');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

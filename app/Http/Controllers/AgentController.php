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
}

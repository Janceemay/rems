<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller {
    public function index() {
        $developers = Developer::paginate(15);
        return view('developers.index', compact('developers'));
    }

    public function create()
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        return view('developers.create');
    }

    public function store(Request $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'developer_name'  => 'required|string|max:100',
            'contact_person'  => 'nullable|string|max:100',
            'contact_number'  => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:100',
            'address'         => 'nullable|string|max:255',
            'description'     => 'nullable|string|max:500',
        ]);

        $developer = Developer::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'developers',
            'target_id' => $developer->developer_id,
            'remarks' => "Developer '{$developer->developer_name}' created by " . Auth::user()->full_name,
        ]);

        return redirect()->route('developers.index')->with('success', 'Developer created successfully.');
    }

    public function show(Developer $developer) {
        $developer->load('properties');
        return view('developers.show', compact('developer'));
    }

    public function edit(Developer $developer) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        return view('developers.edit', compact('developer'));
    }

    public function update(Request $request, Developer $developer) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'developer_name'  => 'required|string|max:100',
            'contact_person'  => 'nullable|string|max:100',
            'contact_number'  => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:100',
            'address'         => 'nullable|string|max:255',
            'description'     => 'nullable|string|max:500',
        ]);

        $developer->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'developers',
            'target_id' => $developer->developer_id,
            'remarks' => "Developer '{$developer->developer_name}' updated by " . Auth::user()->full_name,
        ]);

        return redirect()->route('developers.index')->with('success', 'Developer updated successfully.');
    }

    public function destroy(Developer $developer) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $developerName = $developer->developer_name;
        $developer->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'developers',
            'target_id' => $developer->developer_id,
            'remarks' => "Developer '{$developerName}' deleted by " . Auth::user()->full_name,
        ]);

        return redirect()->route('developers.index')->with('success', 'Developer deleted successfully.');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller {
    public function index()
    {
        $this->authorizeRoles(['Admin', 'Sales Manager', 'Agent']);
        $clients = Client::with('user')->paginate(20);
        return view('clients.index', compact('clients'));
    }

    public function show(Client $client) {
        $this->authorizeRoles(['Admin', 'Sales Manager', 'Agent', 'Client']);

        $client->load('user', 'transactions.property');

        if (Auth::user()->isRole('Client') && Auth::id() !== $client->user_id) {
            abort(403, 'Unauthorized to view this client record.');
        }

        return view('clients.show', compact('client'));
    }

    public function create() {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $users = User::whereHas('role', function ($q) {
            $q->where('role_name', 'Client');
        })->doesntHave('client')->get();

        return view('clients.create', compact('users'));
    }

    public function store(Request $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:clients,user_id',
            'contact_no' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:18|max:100',
            'financing_type' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
        ]);

        $client = Client::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'clients',
            'target_id' => $client->client_id,
            'remarks' => "Client profile created for User ID {$client->user_id} by " . Auth::user()->full_name,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $users = User::whereHas('role', function ($q) {
            $q->where('role_name', 'Client');
        })->get();

        return view('clients.edit', compact('client', 'users'));
    }

    public function update(Request $request, Client $client) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:clients,user_id,' . $client->client_id . ',client_id',
            'contact_no' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:18|max:100',
            'financing_type' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
        ]);

        $client->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'clients',
            'target_id' => $client->client_id,
            'remarks' => "Client ID {$client->client_id} updated by " . Auth::user()->full_name,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $clientId = $client->client_id;
        $client->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'clients',
            'target_id' => $clientId,
            'remarks' => "Client ID {$clientId} deleted by " . Auth::user()->full_name,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function profile()
    {
        $user = Auth::user();

        if (!$user->isRole('Client')) {
            abort(403, 'Unauthorized access.');
        }

        return view('profiles.client', compact('user'));
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

        if ($request->hasFile('image')) {
            $data = $request->file('image')->store('properties', 'public');
            $data = '/storage/' . $data;
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
            'remarks' => "Client profile updated by {$user->full_name}",
        ]);

        return redirect()->route('profiles.client')->with('success', 'Profile updated successfully.');
    }
}

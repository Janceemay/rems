<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Models\{Property, Developer, AuditLog, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query()->with('developer');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%")
                    ->orWhere('property_code', 'like', "%{$q}%");
            });
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('developer_id')) {
            $query->where('developer_id', $request->developer_id);
        }

        $properties = $query->paginate(12);
        $developers = Developer::all();

        return view('properties.index', compact('properties', 'developers'));
    }

    public function create()
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $developers = Developer::all();
        return view('properties.create', compact('developers'));
    }

    public function store(Request $request)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $validator = Validator::make($request->all(), (new StorePropertyRequest())->rules());
        $data = $validator->validate();

        // Auto-generate property code
        $lastProperty = Property::orderBy('property_id', 'desc')->first();
        $nextNumber = ($lastProperty ? intval(str_replace('PROP-', '', $lastProperty->property_code)) : 0) + 1;
        $data['property_code'] = 'PROP-' . $nextNumber;

        $property = new Property($data);

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('properties', 'public');
            $property->image_url = $path;
        }

        $property->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'properties',
            'target_id' => $property->property_id,
            'remarks' => "Property {$property->property_code} created by " . Auth::user()->full_name,
        ]);

        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }

    public function show($property_id)
    {
        $property = Property::where('property_id', $property_id)->firstOrFail();
        $property->load('developer', 'transactions', 'assignedAgents');
        $agents = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('properties.show', compact('property', 'agents'));
    }

    public function edit($property_id)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $property = Property::where('property_id', $property_id)->firstOrFail();
        $developers = Developer::all();

        return view('properties.edit', compact('property', 'developers'));
    }

    public function update(Request $request, $property_id)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $property = Property::where('property_id', $property_id)->firstOrFail();

        $validator = Validator::make($request->all(), (new StorePropertyRequest())->rules());
        $data = $validator->validate();

        $property->fill($data);

        if ($request->hasFile('image')) {
            if ($property->image_url && file_exists(public_path('storage/' . $property->image_url))) {
                unlink(public_path('storage/' . $property->image_url));
            }

            $path = $request->file('image')->store('properties', 'public');
            $property->image_url = $path;
        }

        $property->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'properties',
            'target_id' => $property->property_id,
            'remarks' => "Property {$property->property_code} updated by " . Auth::user()->full_name,
        ]);

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    public function assignAgent(Request $request, $property_id)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,user_id',
        ]);

        $property = Property::findOrFail($property_id);
        $property->assignedAgents()->syncWithoutDetaching([$request->agent_id]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'assign_agent',
            'target_table' => 'property_assignments',
            'target_id' => $property->property_id,
            'remarks' => "Agent ID {$request->agent_id} assigned to property '{$property->title}'",
        ]);

        return back()->with('success', 'Agent added successfully.');
    }

    public function updateAgents(Request $request, $property_id)
    {
        $request->validate([
            'agent_ids' => 'array',
            'agent_ids.*' => 'exists:users,user_id',
        ]);

        $property = Property::findOrFail($property_id);
        $property->assignedAgents()->sync($request->agent_ids ?? []);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update_agents',
            'target_table' => 'property_assignments',
            'target_id' => $property->property_id,
            'remarks' => "Updated agent assignments for property '{$property->title}'",
        ]);

        return back()->with('success', 'Assigned agents updated successfully.');
    }

    public function removeAgent($property_id, $agent_id)
    {
        $property = Property::findOrFail($property_id);
        $property->assignedAgents()->detach($agent_id);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'remove_agent',
            'target_table' => 'property_assignments',
            'target_id' => $property->property_id,
            'remarks' => "Agent ID {$agent_id} removed from property '{$property->title}'",
        ]);

        return back()->with('success', 'Agent removed successfully.');
    }

    public function destroy($property_id)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $property = Property::where('property_id', $property_id)->firstOrFail();

        if ($property->image_url && file_exists(public_path('storage/' . $property->image_url))) {
            unlink(public_path('storage/' . $property->image_url));
        }
        if ($property->floor_plan && file_exists(public_path($property->floor_plan))) {
            unlink(public_path($property->floor_plan));
        }

        $property->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'properties',
            'target_id' => $property_id,
            'remarks' => "Property {$property->property_code} deleted by " . Auth::user()->full_name,
        ]);

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }

    private function authorizeRoles(array $roles)
    {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

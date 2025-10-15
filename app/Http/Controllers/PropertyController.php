<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Models\{Property, Developer, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PropertyController extends Controller {
    public function index(Request $request) {
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

    public function create() {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $developers = Developer::all();
        return view('properties.create', compact('developers'));
    }

    public function store(Request $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $validator = Validator::make($request->all(), (new StorePropertyRequest())->rules());
        $data = $validator->validate();

        if (empty($data['property_code'])) {
            $data['property_code'] = 'PROP-' . Str::upper(Str::random(6));
        }

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('properties', 'public');
            $data['image_url'] = '/storage/' . $data['image_url'];
        }

        if ($request->hasFile('floor_plan')) {
            $data['floor_plan'] = $request->file('floor_plan')->store('floorplans', 'public');
            $data['floor_plan'] = '/storage/' . $data['floor_plan'];
        }

        $property = Property::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'properties',
            'target_id' => $property->property_id,
            'remarks' => "Property {$property->property_code} created by " . Auth::user()->full_name,
        ]);

        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }

    public function show(Property $property) {
        $property->load('developer', 'transactions', 'assignedAgents');
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $developers = Developer::all();
        return view('properties.edit', compact('property', 'developers'));
    }

    public function update(Request $request, Property $property) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $validator = Validator::make($request->all(), (new StorePropertyRequest())->rules());
        $data = $validator->validate();

        if ($request->hasFile('image')) {
            if ($property->image_url && file_exists(public_path($property->image_url))) {
                unlink(public_path($property->image_url));
            }
            $data['image_url'] = '/storage/' . $request->file('image')->store('properties', 'public');
        }

        if ($request->hasFile('floor_plan')) {
            if ($property->floor_plan && file_exists(public_path($property->floor_plan))) {
                unlink(public_path($property->floor_plan));
            }
            $data['floor_plan'] = '/storage/' . $request->file('floor_plan')->store('floorplans', 'public');
        }

        $property->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'properties',
            'target_id' => $property->property_id,
            'remarks' => "Property {$property->property_code} updated by " . Auth::user()->full_name,
        ]);

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if ($property->image_url && file_exists(public_path($property->image_url))) {
            unlink(public_path($property->image_url));
        }
        if ($property->floor_plan && file_exists(public_path($property->floor_plan))) {
            unlink(public_path($property->floor_plan));
        }

        $property->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'properties',
            'target_id' => $property->property_id,
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AuditLog;

class PropertyController extends Controller {
    public function index(Request $request) {
        $query = Property::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('title','like',"%{$q}%")
                  ->orWhere('location','like',"%{$q}%")
                  ->orWhere('property_code','like',"%{$q}%");
        }

        if ($request->filled('property_type')) {
            $query->where('property_type',$request->property_type);
        }

        if ($request->filled('status')) {
            $query->where('status',$request->status);
        }

        $properties = $query->paginate(12);
        $developers = Developer::all();
        return view('properties.index', compact('properties','developers'));
    }

    public function create()
    {
        $developers = Developer::all();
        return view('properties.create', compact('developers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), (new StorePropertyRequest())->rules());
        $data = $validator->validate();

        if (!($data['property_code'] ?? false)) {
            $data['property_code'] = 'PROP-'.Str::upper(Str::random(6));
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties','public');
            $data['image_url'] = '/storage/'.$path;
        }

        if ($request->hasFile('floor_plan')) {
            $path = $request->file('floor_plan')->store('floorplans','public');
            $data['floor_plan'] = '/storage/'.$path;
        }

        $property = Property::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'properties',
            'target_id' => $property->property_id,
            'remarks' => 'Property created'
        ]);

        return redirect()->route('properties.index')->with('success','Property created');
    }
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
}

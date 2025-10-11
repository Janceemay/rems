<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller {
    public function index() {
        $developers = Developer::paginate(20);
        return view('developers.index', compact('developers'));
    }

    public function create() {
        return view('developers.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'developer_name'=>'required|string|max:100',
            'contact_person'=>'nullable|string|max:100',
            'contact_number'=>'nullable|string|max:20',
            'email'=>'nullable|email',
            'address'=>'nullable|string'
        ]);

        Developer::create($data);
        return redirect()->route('developers.index')->with('success','Developer created');
    }

    public function edit(Developer $developer) {
        return view('developers.edit', compact('developer'));
    }

    public function update(Request $request, Developer $developer) {
        $data = $request->validate([
            'developer_name'=>'required|string|max:100',
            'contact_person'=>'nullable|string|max:100',
            'contact_number'=>'nullable|string|max:20',
            'email'=>'nullable|email',
            'address'=>'nullable|string'
        ]);

        $developer->update($data);
        return redirect()->route('developers.index')->with('success','Developer updated');
    }

    public function destroy(Developer $developer) {
        $developer->delete();
        return redirect()->route('developers.index')->with('success','Developer deleted');
    }

    public function show(Developer $developer) {
        return view('developers.show', compact('developer'));
    }
}

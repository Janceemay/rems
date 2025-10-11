<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller {
    public function index() {
        $clients = Client::with('user')->paginate(20);
        return view('clients.index', compact('clients'));
    }

    public function show(Client $client) {
        $client->load('transactions.property','user');
        return view('clients.show', compact('client'));
    }

    public function create() {
        $users = User::whereHas('role', function($q){
            $q->where('role_name','Client');
        })->get();
        return view('clients.create', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:clients,user_id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255'
        ]);

        Client::create($request->only('user_id','phone','address'));
        return redirect()->route('clients.index')->with('success','Client created');
    }

    public function edit(Client $client) {
        $users = User::whereHas('role', function($q){
            $q->where('role_name','Client');
        })->get();
        return view('clients.edit', compact('client','users'));
    }

    public function update(Request $request, Client $client) {
        $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:clients,user_id,'.$client->getKey().',client_id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255'
        ]);

        $client->update($request->only('user_id','phone','address'));
        return redirect()->route('clients.index')->with('success','Client updated');
    }

    public function destroy(Client $client) {
        $client->delete();
        return redirect()->route('clients.index')->with('success','Client deleted');
    }
}

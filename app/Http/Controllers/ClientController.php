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
}

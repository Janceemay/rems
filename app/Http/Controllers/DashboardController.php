<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Payment;

class DashboardController extends Controller {
    public function index() {
        $totalProperties = Property::count();
        $available = Property::where('status','Available')->count();
        $sold = Property::where('status','Sold')->count();

        $recentTransactions = Transaction::with('client.user','property','agent')->latest()->take(10)->get();
        $topAgents = User::whereHas('transactions')->withCount('transactions')->orderByDesc('transactions_count')->take(5)->get();

        return view('dashboard.index', compact('totalProperties','available','sold','recentTransactions','topAgents'));
    }
}

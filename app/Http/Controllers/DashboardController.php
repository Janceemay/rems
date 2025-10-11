<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function store(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'required|exists:transactions,id'
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        if ($transaction->status !== 'Approved') {
            return back()->withErrors(['transaction_id'=>'Payments can only be made for approved transactions.'])->withInput();
        }
        
        $payment = new Payment;
        $payment->transaction_id = $transaction->id;
        $payment->amount = $request->amount;
        $payment->payment_date = now();
        $payment->received_by = Auth::id();
        $payment->save();

        $totalPaid = $transaction->payments()->sum('amount');
        if ($totalPaid >= $transaction->property->price) {
            $transaction->status = 'Completed';
            $transaction->save();
        }

        return redirect()->back()->with('success','Payment recorded successfully.');
    }
}

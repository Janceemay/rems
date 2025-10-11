<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Property;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller {
    public function index() {
        $transactions = Transaction::with('client.user','property','agent')->paginate(20);
        return view('transactions.index', compact('transactions'));
    }

    public function create() {
        $clients = Client::with('user')->get();
        $properties = Property::where('status','Available')->get();
        return view('transactions.create', compact('clients','properties'));
    }

    public function store(StoreTransactionRequest $request) {
        $data = $request->validated();

        $exists = Transaction::where('client_id',$data['client_id'])->where('property_id',$data['property_id'])->first();
        if ($exists) {
            return back()->withErrors(['property_id'=>'A transaction for this client and property already exists.'])->withInput();
        }

        $transaction = Transaction::create($data);
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => 'Transaction created'
        ]);

        return redirect()->route('transactions.index')->with('success','Transaction created');
    }

    public function show(Transaction $transaction) {
        $transaction->load('payments','commissions','client.user','property','agent');
        return view('transactions.show', compact('transaction'));
    }
    
    public function approve(Transaction $transaction){
        $transaction->status = 'Approved';
        $transaction->approval_date = now();
        $transaction->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'approve',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => 'Transaction approved by '.optional(Auth::user())->full_name
        ]);

        return redirect()->back()->with('success','Transaction approved.');
    }

    public function cancel(Request $request, Transaction $transaction) {
        $request->validate(['reason'=>'required|string']);
        $transaction->status = 'Cancelled';
        $transaction->cancellation_reason = $request->reason;
        $transaction->save();
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'cancel',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => $request->reason
        ]);

        return redirect()->back()->with('success','Transaction cancelled.');
    }
}

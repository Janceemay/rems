<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller {
    public function index() {
        $payments = Payment::with('transaction.client.user','transaction.property')->paginate(20);
        return view('payments.index', compact('payments'));
    }

    public function store(StorePaymentRequest $request) {
        $data = $request->validated();
        $payment = Payment::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'payments',
            'target_id' => $payment->payment_id,
            'remarks' => 'Payment recorded'
        ]);

        return redirect()->back()->with('success','Payment recorded.');
    }

    public function edit(Payment $payment) {
        return view('payments.edit', compact('payment'));
    }

    public function update(StorePaymentRequest $request, Payment $payment) {
        $data = $request->validated();
        $payment->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'payments',
            'target_id' => $payment->payment_id,
            'remarks' => 'Payment updated'
        ]);

        return redirect()->route('payments.index')->with('success','Payment updated.');
    }
    
    public function destroy(Payment $payment) {
        $payment->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'payments',
            'target_id' => $payment->payment_id,
            'remarks' => 'Payment deleted'
        ]);

        return redirect()->back()->with('success','Payment deleted.');
    }
}

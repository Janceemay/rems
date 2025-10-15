<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\{Payment, Transaction, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller {
    public function index()
    {
        $user = Auth::user();
        $role = optional($user->role)->role_name;

        if ($role === 'Admin' || $role === 'Sales Manager') {
            $payments = Payment::with('transaction.client.user', 'transaction.property', 'transaction.agent')
                ->latest()
                ->paginate(20);
        } elseif ($role === 'Agent') {
            $payments = Payment::whereHas('transaction', fn($q) => $q->where('agent_id', $user->user_id))
                ->with('transaction.client.user', 'transaction.property')
                ->latest()
                ->paginate(20);
        } elseif ($role === 'Client') {
            $payments = Payment::whereHas('transaction', fn($q) => $q->where('client_id', optional($user->client)->client_id))
                ->with('transaction.property')
                ->latest()
                ->paginate(20);
        } else {
            abort(403, 'Unauthorized access.');
        }

        return view('payments.index', compact('payments'));
    }

    public function store(StorePaymentRequest $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager', 'Agent']);

        $data = $request->validated();
        $transaction = Transaction::with('property', 'payments')->findOrFail($data['transaction_id']);

        if ($transaction->status !== 'Approved') {
            return back()->withErrors(['transaction_id' => 'Payments can only be made for approved transactions.'])->withInput();
        }

        $totalPaid = $transaction->payments->sum('amount_paid');
        $remaining = $transaction->property->price - $totalPaid;

        if ($data['amount_paid'] > $remaining) {
            return back()->withErrors(['amount_paid' => 'Payment exceeds remaining balance.'])->withInput();
        }

        $payment = Payment::create([
            'transaction_id' => $transaction->transaction_id,
            'amount_due' => $transaction->property->price,
            'amount_paid' => $data['amount_paid'],
            'payment_date' => now(),
            'payment_status' => 'Completed',
            'balance' => $remaining - $data['amount_paid'],
            'remarks' => $data['remarks'] ?? null,
        ]);

        if ($payment->balance <= 0) {
            $transaction->update(['status' => 'Completed']);
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'payments',
            'target_id' => $payment->payment_id,
            'remarks' => "Payment of ₱" . number_format($payment->amount_paid, 2) . " recorded for Transaction #{$transaction->transaction_id}",
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        return view('payments.edit', compact('payment'));
    }

    public function update(StorePaymentRequest $request, Payment $payment) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validated();
        $transaction = $payment->transaction()->with('property', 'payments')->first();

        $totalPaid = $transaction->payments()->where('payment_id', '!=', $payment->payment_id)->sum('amount_paid');
        $remaining = $transaction->property->price - $totalPaid;

        if ($data['amount_paid'] > $remaining) {
            return back()->withErrors(['amount_paid' => 'Updated payment exceeds remaining balance.'])->withInput();
        }

        $payment->update([
            'amount_paid' => $data['amount_paid'],
            'payment_date' => now(),
            'balance' => $remaining - $data['amount_paid'],
            'remarks' => $data['remarks'] ?? null,
        ]);

        $totalNow = $transaction->payments()->sum('amount_paid');
        if ($totalNow >= $transaction->property->price) {
            $transaction->update(['status' => 'Completed']);
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'payments',
            'target_id' => $payment->payment_id,
            'remarks' => "Payment #{$payment->payment_id} updated by " . Auth::user()->full_name,
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $paymentId = $payment->payment_id;
        $payment->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'payments',
            'target_id' => $paymentId,
            'remarks' => "Payment #{$paymentId} deleted by " . Auth::user()->full_name,
        ]);

        return redirect()->back()->with('success', 'Payment deleted successfully.');
    }

    public function approvePayment(Payment $payment) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $payment->update(['payment_status' => 'Approved']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'approve',
            'target_table' => 'payments',
            'target_id' => $payment->payment_id,
            'remarks' => "Payment #{$payment->payment_id} approved by " . Auth::user()->full_name,
        ]);

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

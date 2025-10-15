<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Commission, AuditLog, Transaction, User};

class CommissionController extends Controller {
    public function index() {
        $user = Auth::user();
        $role = optional($user->role)->role_name;

        if (in_array($role, ['Admin', 'Sales Manager'])) {
            $commissions = Commission::with('agent', 'transaction.property', 'transaction.client.user')
                ->latest()
                ->paginate(20);
        } elseif ($role === 'Agent') {
            $commissions = Commission::where('agent_id', $user->user_id)
                ->with('transaction.property', 'transaction.client.user')
                ->latest()
                ->paginate(20);
        } else {
            abort(403, 'Unauthorized access.');
        }

        return view('commissions.index', compact('commissions'));
    }

    public function store(Request $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'agent_id' => 'required|exists:users,user_id',
            'percentage' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string'
        ]);

        $transaction = Transaction::with('property')->findOrFail($data['transaction_id']);
        $amount = ($data['percentage'] / 100) * $transaction->property->price;

        $commission = Commission::create([
            'transaction_id' => $transaction->transaction_id,
            'agent_id' => $data['agent_id'],
            'percentage' => $data['percentage'],
            'amount' => $amount,
            'approval_status' => 'Pending',
            'date_generated' => now(),
            'remarks' => $data['remarks'] ?? 'Commission created manually',
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'commissions',
            'target_id' => $commission->commission_id,
            'remarks' => "Commission generated for Agent ID {$data['agent_id']} (₱" . number_format($amount, 2) . ")",
        ]);

        return redirect()->route('commissions.index')->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission) {
        $commission->load('agent', 'transaction.client.user', 'transaction.property');
        return view('commissions.show', compact('commission'));
    }

    public function edit(Commission $commission) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        return view('commissions.edit', compact('commission'));
    }

    public function update(Request $request, Commission $commission) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'percentage' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string',
        ]);

        $transaction = $commission->transaction()->with('property')->first();
        $newAmount = ($data['percentage'] / 100) * $transaction->property->price;

        $commission->update([
            'percentage' => $data['percentage'],
            'amount' => $newAmount,
            'remarks' => $data['remarks'] ?? 'Commission updated',
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'commissions',
            'target_id' => $commission->commission_id,
            'remarks' => "Commission #{$commission->commission_id} updated to {$data['percentage']}%",
        ]);

        return redirect()->route('commissions.index')->with('success', 'Commission updated successfully.');
    }

    public function approve(Commission $commission) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $commission->update([
            'approval_status' => 'Approved',
            'approved_by' => Auth::id(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'approve',
            'target_table' => 'commissions',
            'target_id' => $commission->commission_id,
            'remarks' => "Commission #{$commission->commission_id} approved by " . Auth::user()->full_name,
        ]);

        return redirect()->back()->with('success', 'Commission approved successfully.');
    }

    public function reject(Commission $commission) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $commission->update([
            'approval_status' => 'Rejected',
            'approved_by' => Auth::id(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'reject',
            'target_table' => 'commissions',
            'target_id' => $commission->commission_id,
            'remarks' => "Commission #{$commission->commission_id} rejected by " . Auth::user()->full_name,
        ]);

        return redirect()->back()->with('success', 'Commission rejected successfully.');
    }

    public function destroy(Commission $commission) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $commissionId = $commission->commission_id;
        $commission->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'commissions',
            'target_id' => $commissionId,
            'remarks' => "Commission #{$commissionId} deleted by " . Auth::user()->full_name,
        ]);

        return redirect()->back()->with('success', 'Commission deleted successfully.');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

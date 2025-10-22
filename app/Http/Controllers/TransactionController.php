<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\{Transaction, Client, Property, AuditLog, Commission};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = optional($user->role)->role_name;

        if ($role === 'Admin' || $role === 'Sales Manager') {
            $transactions = Transaction::with(['client.user', 'property', 'agent'])
                ->latest()
                ->paginate(20);
        } elseif ($role === 'Agent') {
            $transactions = Transaction::with(['client.user', 'property'])
                ->where('agent_id', $user->user_id)
                ->latest()
                ->paginate(20);
        } elseif ($role === 'Client') {
            $transactions = Transaction::with(['property', 'agent'])
                ->where('client_id', optional($user->client)->client_id)
                ->latest()
                ->paginate(20);
        } else {
            abort(403, 'Unauthorized access.');
        }

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        if ($user->isRole('Client') && $request->has('property_id')) {
            $property = Property::findOrFail($request->property_id);
            $client = Client::where('user_id', $user->user_id)->first();

            if (!$client) {
                abort(403, 'Client profile not found.');
            }

            return view('transactions.create', [
                'isClient' => true,
                'property' => $property,
                'client' => $client,
            ]);
        }

        $this->authorizeRoles(['Admin', 'Sales Manager', 'Agent']);

        $clients = Client::with('user')->get();
        $properties = Property::where('status', 'Available')->get();

        return view('transactions.create', compact('clients', 'properties'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // CLIENT INQUIRY FLOW
        if ($user->isRole('Client')) {
            $request->validate([
                'property_id' => 'required|exists:properties,property_id',
                'inquiry_details' => 'nullable|string|max:1000',
            ]);

            $clientId = optional($user->client)->client_id;
            if (!$clientId) {
                abort(403, 'Client profile not found.');
            }

            $property = Property::findOrFail($request->property_id);

            if (!$property->isAvailable()) {
                return back()->withErrors(['property_id' => 'This property is not available.'])->withInput();
            }

            $exists = Transaction::where('client_id', $clientId)
                ->where('property_id', $property->property_id)
                ->whereNotIn('status', ['Canceled'])
                ->first();

            if ($exists) {
                return back()->withErrors(['property_id' => 'You already have an inquiry for this property.'])->withInput();
            }

            $assignedAgent = $property->assignedAgents->first()?->user_id;

            if (!$assignedAgent) {
                return back()->withErrors(['property_id' => 'No agent assigned to this property.'])->withInput();
            }

            $transaction = Transaction::create([
                'client_id' => $clientId,
                'property_id' => $property->property_id,
                'agent_id' => $assignedAgent,
                'status' => 'pending',
                'request_date' => now(),
                'total_amount' => $property->price,
                'inquiry_details' => $request->inquiry_details,
            ]);

            $property->update(['status' => 'Reserved']);

            AuditLog::create([
                'user_id' => $user->user_id,
                'action' => 'inquire',
                'target_table' => 'transactions',
                'target_id' => $transaction->transaction_id,
                'remarks' => "Client inquiry for property '{$property->title}'",
            ]);

            return redirect()->route('properties.show', $property->property_id)->with('success', 'Inquiry submitted successfully.');
        }

        // STAFF TRANSACTION FLOW
        $this->authorizeRoles(['Admin', 'Sales Manager', 'Agent']);

        $data = $request->validate([
            'client_id' => 'required|exists:clients,client_id',
            'property_id' => 'required|exists:properties,property_id',
            'agent_id' => 'nullable|exists:users,user_id',
        ]);

        $property = Property::findOrFail($data['property_id']);

        if (!$property->isAvailable()) {
            return back()->withErrors(['property_id' => 'This property is not available for sale.'])->withInput();
        }

        $exists = Transaction::where('client_id', $data['client_id'])
            ->where('property_id', $data['property_id'])
            ->whereNotIn('status', ['Canceled'])
            ->first();

        if ($exists) {
            return back()->withErrors(['property_id' => 'A transaction for this client and property already exists.'])->withInput();
        }

        if ($user->isRole('Agent')) {
            $data['agent_id'] = $user->user_id;
        }

        $transaction = Transaction::create([
            'client_id' => $data['client_id'],
            'agent_id' => $data['agent_id'] ?? null,
            'property_id' => $data['property_id'],
            'status' => 'Pending',
            'request_date' => now(),
            'total_amount' => $property->price,
        ]);

        $property->update(['status' => 'Reserved']);

        AuditLog::create([
            'user_id' => $user->user_id,
            'action' => 'create',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => "Transaction created for property '{$property->title}' by {$user->full_name}",
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['payments', 'commissions', 'client.user', 'property', 'agent']);

        $user = Auth::user();
        if (
            $user->isRole('Client') && $transaction->client_id !== optional($user->client)->client_id ||
            $user->isRole('Agent') && $transaction->agent_id !== $user->user_id
        ) {
            abort(403, 'Unauthorized to view this transaction.');
        }

        return view('transactions.show', compact('transaction'));
    }

    public function approve(Transaction $transaction)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if ($transaction->status === 'Approved') {
            return back()->with('info', 'Transaction is already approved.');
        }

        $transaction->update([
            'status' => 'Approved',
            'approval_date' => now(),
        ]);

        $transaction->property->update(['status' => 'Sold']);

        Commission::create([
            'transaction_id' => $transaction->transaction_id,
            'agent_id' => $transaction->agent_id,
            'amount' => $transaction->total_amount * 0.03,
            'approval_status' => 'pending',
            'date_generated' => now(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'approve',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => "Transaction #{$transaction->transaction_id} approved by " . Auth::user()->full_name,
        ]);

        return redirect()->back()->with('success', 'Transaction approved successfully.');
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        $transaction->update([
            'status' => 'Canceled',
            'cancellation_reason' => $request->reason,
        ]);

        if ($transaction->property) {
            $transaction->property->update(['status' => 'Available']);
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'cancel',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => "Transaction #{$transaction->transaction_id} canceled: {$request->reason}",
        ]);

        return redirect()->back()->with('success', 'Transaction canceled successfully.');
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $request->validate(['status' => 'required|string|in:Pending,Approved,Canceled,Completed']);

        $transaction->update(['status' => $request->status]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update_status',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => "Status changed to {$request->status} by " . Auth::user()->full_name,
        ]);

        return redirect()->back()->with('success', 'Transaction status updated.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeRoles(['Admin']);

        $transaction->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => "Transaction deleted by " . Auth::user()->full_name,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    private function authorizeRoles(array $roles)
    {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

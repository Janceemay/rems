<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Property, Transaction, User, Payment, Commission, Team, Quota, AuditLog, Agent};

class DashboardController extends Controller {
    public function index() {
        $user = Auth::user();
        $role = strtolower($user->role->role_name ?? '');

        return match ($role) {
            'admin' => $this->showAdminDashboard(),
            'sales manager' => $this->showManagerDashboard(),
            'agent' => $this->showAgentDashboard(),
            'client' => $this->showClientDashboard(),
            default => abort(403, 'Unauthorized role access.'),
        };
    }

    public function showAdminDashboard()
    {
        $totalProperties = Property::count();
        $available = Property::where('status', 'Available')->count();
        $sold = Property::where('status', 'Sold')->count();
        $totalUsers = User::count();
        $recentTransactions = Transaction::with(['client.user', 'property', 'agent'])->latest()->take(10)->get();

        return view('dashboard.admin', compact(
            'totalProperties',
            'available',
            'sold',
            'totalUsers',
            'recentTransactions'
        ));
    }

    public function showManagerDashboard()
    {
        $manager = Auth::user();
        
        $pending = Transaction::where('status', 'Pending')
            ->count();

        $ongoing = Transaction::where('status', 'Ongoing')
            ->count();

        $completed = Transaction::where('status', 'Completed')
            ->count();

        $totalAgents = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->count();
        $activeQuotas = Quota::where('manager_id', $manager->user_id)->count();
        $totalSales = Transaction::whereHas('agent', function ($q) use ($manager) {
            $q->where('transaction_id', $manager->user_id);
        })->sum('total_amount');

        $topAgents = User::whereHas('transactions')
            ->withCount('transactions')
            ->orderByDesc('transactions_count')
            ->take(5)
            ->get();

        $members = Agent::where('manager_id', $manager->user_id)
            ->orderByRaw("CASE WHEN rank = 'Top Selling Agent' THEN 0 ELSE 1 END")
            ->orderBy('commission', 'desc')
            ->get();

        Agent::query()->update(['rank' => '']);

        $topAgent = Agent::orderBy('commission', 'desc')->first();

        if ($topAgent) {
            $topAgent->update(['rank' => 'Top Selling Agent']);
        }

        foreach ($members as $member) {
            $info = User::find($member->user_id);
            $members->full_name = $info->full_name;
        }

        $topselling = $topAgent;


        return view('dashboard.manager', compact(
            'totalAgents',
            'activeQuotas',
            'totalSales',
            'topAgents',
            'pending',
            'ongoing',
            'completed',
            'members',
            'topselling'
        ));
    }

    public function showAgentDashboard()
    {
        $agent = Auth::user();

        $assignedProperties = $agent->propertiesAssigned()->count();
        $activeTransactions = Transaction::where('agent_id', $agent->user_id)->count();
        $pendingApprovals = Transaction::where('agent_id', $agent->user_id)
            ->where('status', 'Pending')
            ->count();
        $totalCommission = Commission::where('agent_id', $agent->user_id)
            ->where('approval_status', 'approved')
            ->sum('amount');

        $recentTransactions = Transaction::with(['client.user', 'property'])
            ->where('agent_id', $agent->user_id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.agent', compact(
            'assignedProperties',
            'activeTransactions',
            'pendingApprovals',
            'totalCommission',
            'recentTransactions'
        ));
    }

    public function showClientDashboard()
    {
        $client = Auth::user();

        $transactions = Transaction::with(['property', 'agent'])
            ->where('client_id', optional($client->client)->client_id)
            ->get();

        $totalSpent = $transactions->sum('total_amount');
        $activeTransactions = $transactions->where('status', 'Approved')->count();
        $completedTransactions = $transactions->where('status', 'Completed')->count();

        $recentPayments = Payment::whereIn('transaction_id', $transactions->pluck('transaction_id'))
            ->latest()
            ->take(5)
            ->get();

        // Assume client is paying for one active property
        $activeTransaction = $transactions->firstWhere('status', 'Approved');
        $property = $activeTransaction?->property;

        $propertyPrice = $property?->price ?? 0;
        $totalPaid = $activeTransaction
            ? Payment::where('transaction_id', $activeTransaction->transaction_id)->sum('amount_paid')
            : 0;
        $totalBalance = max(0, $propertyPrice - $totalPaid);

        $paidPercent = $propertyPrice > 0 ? round(($totalPaid / $propertyPrice) * 100) : 0;
        $balancePercent = 100 - $paidPercent;

        return view('dashboard.client', compact(
            'transactions',
            'totalSpent',
            'activeTransactions',
            'completedTransactions',
            'recentPayments',
            'property',
            'totalPaid',
            'totalBalance',
            'paidPercent',
            'balancePercent'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'required|exists:transactions,transaction_id',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        if ($transaction->status !== 'Approved') {
            return back()->withErrors([
                'transaction_id' => 'Payments can only be made for approved transactions.'
            ])->withInput();
        }

        $payment = Payment::create([
            'transaction_id' => $transaction->transaction_id,
            'amount' => $request->amount,
            'payment_date' => now(),
            'status' => 'Completed',
            'balance' => max(0, $transaction->property->price - $transaction->payments()->sum('amount') - $request->amount),
        ]);

        $totalPaid = $transaction->payments()->sum('amount');
        if ($totalPaid >= $transaction->property->price) {
            $transaction->update(['status' => 'Completed']);
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'add_payment',
            'target_table' => 'payments',
            'target_id' => $payment->id,
            'remarks' => 'Payment of ₱' . number_format($payment->amount, 2) . ' recorded for Transaction #' . $transaction->transaction_id,
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }
}

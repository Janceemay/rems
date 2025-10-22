<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Property, Transaction, User, Payment, Commission, Team, Quota, AuditLog, Agent};

class DashboardController extends Controller {
    public function show() {
        $user = Auth::user();
        $role = strtolower($user->role->role_name ?? '');
    
        // Role-based dashboard routing
        return match ($role) {
            'admin' => $this->showAdminDashboard(),
            'sales manager' => $this->showManagerDashboard(),
            'agent' => $this->showAgentDashboard(),
            'client' => $this->showClientDashboard(),
            default => abort(403, 'Unauthorized role access.'),
        };
    }

    public function assignAgent(Request $request, Transaction $transaction) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        
        $validated = $request->validate([
            'agent_id' => 'required|exists:users,user_id'
        ]);
        
        $transaction->update(['agent_id' => $validated['agent_id']]);
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'assign',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => "Transaction assigned to agent by " . Auth::user()->full_name,
        ]);
        
        return redirect()->back()->with('success', 'Transaction assigned to agent');
    }

    public function assignToMe(Transaction $transaction) {
        $this->authorizeRoles(['Agent']);
        
        $transaction->update(['agent_id' => Auth::id()]);
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'accept',
            'target_table' => 'transactions',
            'target_id' => $transaction->transaction_id,
            'remarks' => "Transaction accepted by agent " . Auth::user()->full_name,
        ]);
        
        return redirect()->back()->with('success', 'Transaction accepted');
    }

    private function authorizeRoles(array $roles) {
        $userRole = optional(Auth::user()->role)->role_name ?? '';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
}
    public function showAdminDashboard()
    {
        $totalProperties = Property::count();
        $available = Property::where('status', 'Available')->count();
        $sold = Property::where('status', 'Sold')->count();
        $totalUsers = User::count();
        $recentTransactions = Transaction::with(['client.user', 'property', 'agent'])->latest()->take(10)->get();

        return view('dashboard.admin', [
            'totalProperties' => $totalProperties,
            'available' => $available,
            'sold' => $sold,
            'totalUsers' => $totalUsers,
            'recentTransactions' => $recentTransactions
        ]);
    }

    public function showManagerDashboard()
    {
        $manager = Auth::user();
        
        // Get all transactions with relationships
        $transactions = Transaction::with(['client.user', 'property', 'agent'])->latest()->get();
        
        
        // Get all agents
        $agents = User::whereHas('role', function ($q) {
            $q->where('role_name', 'Agent');
        })->get();

        // Calculate top agent
        $topAgent = $agents->map(function($agent) use ($transactions) {
            $agentTransactions = $transactions->where('agent_id', $agent->user_id);
            return [
                'agent' => $agent,
                'total_sales' => $agentTransactions->sum('total_amount'),
                'completed_count' => $agentTransactions->where('status', 'Completed')->count(),
                'transaction_count' => $agentTransactions->count()
            ];
        })->sortByDesc('total_sales')->first();

        $pending = Transaction::where('status', 'Pending')->count();
        $ongoing = Transaction::where('status', 'Ongoing')->count();
        $completed = Transaction::where('status', 'Completed')->count();

        $totalAgents = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->count();
        $activeQuotas = Quota::where('manager_id', $manager->user_id)->count();
        
        $totalSales = Transaction::where('status', 'Completed')->sum('total_amount');

        $topAgents = User::whereHas('transactions')
            ->withCount('transactions')
            ->orderByDesc('transactions_count')
            ->take(5)
            ->get();

        // Update agent ranks
        Agent::query()->update(['rank' => '']);
        $topSellingAgent = Agent::orderBy('commission', 'desc')->first();
        if ($topSellingAgent) {
            $topSellingAgent->update(['rank' => 'Top Selling Agent']);
        }

        // Get manager's team members with user info
        $members = Agent::where('manager_id', $manager->user_id)
            ->with('user')
            ->get()
            ->map(function($member) {
                $member->full_name = $member->user->full_name ?? 'N/A';
                return $member;
            });

        return view('dashboard.manager', [
            'totalAgents' => $totalAgents,
            'activeQuotas' => $activeQuotas,
            'totalSales' => $totalSales,
            'pending' => $pending,
            'ongoing' => $ongoing,
            'completed' => $completed,
            'members' => $members,
            'topAgent' => $topAgent,
            'transactions' => $transactions,
            'agents' => $agents
        ]);
    }

    public function showAgentDashboard()
    {
        $agent = Auth::user();

        $members = Agent::where('manager_id', $agent->manager_id)
            ->with('user')
            ->get()
            ->map(function($member) {
                $member->full_name = $member->user->full_name ?? 'N/A';
                return $member;
            });

        // Get all transactions for agent dashboard needs
        $transactions = Transaction::with(['client.user', 'property', 'agent'])->latest()->get();

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

        return view('dashboard.agent', [
            'activeTransactions' => $activeTransactions,
            'pendingApprovals' => $pendingApprovals,
            'totalCommission' => $totalCommission,
            'recentTransactions' => $recentTransactions,
            'transactions' => $transactions,
            'members' => $members
        ]);
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

        // Get active transaction for payment tracking
        $activeTransaction = $transactions->firstWhere('status', 'Approved');
        $property = $activeTransaction?->property;

        $propertyPrice = $property?->price ?? 0;
        $totalPaid = $activeTransaction
            ? Payment::where('transaction_id', $activeTransaction->transaction_id)->sum('amount_paid')
            : 0;
        $totalBalance = max(0, $propertyPrice - $totalPaid);

        $paidPercent = $propertyPrice > 0 ? round(($totalPaid / $propertyPrice) * 100) : 0;
        $balancePercent = 100 - $paidPercent;

        return view('dashboard.client', [
            'transactions' => $transactions,
            'totalSpent' => $totalSpent,
            'activeTransactions' => $activeTransactions,
            'completedTransactions' => $completedTransactions,
            'recentPayments' => $recentPayments,
            'property' => $property,
            'totalPaid' => $totalPaid,
            'totalBalance' => $totalBalance,
            'paidPercent' => $paidPercent,
            'balancePercent' => $balancePercent
        ]);
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
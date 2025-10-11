<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commission;
use App\Models\AuditLog;

class CommissionController extends Controller {
    public function index() {
        $commissions = Commission::with('agent','transaction')->paginate(20);
        return view('commissions.index', compact('commissions'));
    }

    public function approve(Commission $commission) {
        $commission->approval_status = 'Approved';
        $commission->approved_by = Auth::id();
        $commission->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'approve',
            'target_table' => 'commissions',
            'target_id' => $commission->getKey(),
            'remarks' => 'Commission approved'
        ]);

        return redirect()->back()->with('success','Commission approved');
    }

    public function reject(Commission $commission) {
        $commission->approval_status = 'Rejected';
        $commission->approved_by = Auth::id();
        $commission->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'reject',
            'target_table' => 'commissions',
            'target_id' => $commission->getKey(),
            'remarks' => 'Commission rejected'
        ]);

        return redirect()->back()->with('success','Commission rejected');
    }

    public function destroy(Commission $commission) {
        $commission->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'target_table' => 'commissions',
            'target_id' => $commission->getKey(),
            'remarks' => 'Commission deleted'
        ]);

        return redirect()->back()->with('success','Commission deleted');
    }

    public function show(Commission $commission) {
        $commission->load('agent','transaction.client.user','transaction.property');
        try {
            return view('commissions.show', compact('commission'));
        } catch (\InvalidArgumentException $e) {
            report($e);
            return response()->json(['commission' => $commission]);
        }
    }

    public function edit(Commission $commission) {
        try {
            return view('commissions.edit', compact('commission'));
        } catch (\InvalidArgumentException $e) {
            report($e);
            return response()->json(['commission' => $commission]);
        }
    }

    public function update(Request $request, Commission $commission) {
        $data = $request->validate([
            'amount'=>'required|numeric|min:0',
            'remarks'=>'nullable|string'
        ]);

        $commission->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'commissions',
            'target_id' => $commission->getKey(),
            'remarks' => 'Commission updated'
        ]);

        return redirect()->route('commissions.index')->with('success','Commission updated');
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'transaction_id'=>'required|exists:transactions,transaction_id',
            'agent_id'=>'required|exists:users,id',
            'amount'=>'required|numeric|min:0',
            'remarks'=>'nullable|string'
        ]);

        $commission = Commission::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'target_table' => 'commissions',
            'target_id' => $commission->getKey(),
            'remarks' => 'Commission created'
        ]);

        return redirect()->route('commissions.index')->with('success','Commission created');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\AuditLog;

class CommissionController extends Controller {
    public function index() {
        $commissions = Commission::with('agent','transaction')->paginate(20);
        return view('commissions.index', compact('commissions'));
    }

    public function approve(Request $request, Commission $commission) {
        $commission->approval_status = 'Approved';
        $commission->approved_by = auth()->id();
        $commission->save();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'approve',
            'target_table' => 'commissions',
            'target_id' => $commission->commission_id,
            'remarks' => 'Commission approved'
        ]);

        return redirect()->back()->with('success','Commission approved');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class AuditController extends Controller{
    public function index(Request $request) {
        $query = AuditLog::with('user')->orderByDesc('timestamp');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model')) {
            $query->where('target_table', $request->model);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('timestamp', [$request->date_from, $request->date_to]);
        }

        $logs = $query->paginate(25);

        $users = User::select('user_id', 'full_name')->get();
        $actions = AuditLog::select('action')->distinct()->pluck('action');
        $models = AuditLog::select('target_table')->distinct()->pluck('target_table');

        return view('audit.index', compact('logs', 'users', 'actions', 'models'));
    }

    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);
        return view('audit.show', compact('log'));
    }
}

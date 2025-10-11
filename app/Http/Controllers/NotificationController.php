<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller {
    public function index() {
        $notifications = Notification::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('notifications.index', compact('notifications'));
    }
    
    public function markRead(Notification $notification) {
        Gate::authorize('update', $notification);
        $notification->is_read = true;
        $notification->save();

        return back();
    }
}

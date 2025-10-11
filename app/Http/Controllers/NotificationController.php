<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller {
    public function index() {
        $notifications = Notification::where('user_id', auth()->id())->orderByDesc('created_at')->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification) {
        $this->authorize('update',$notification);
        $notification->is_read = true;
        $notification->save();

        return back();
    }

    
}

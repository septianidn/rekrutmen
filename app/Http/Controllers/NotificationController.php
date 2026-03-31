<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = \App\Models\Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        NotificationService::markAsRead($notification->id);

        if ($notification->link) {
            return redirect($notification->link);
        }

        return back();
    }

    public function markAllAsRead()
    {
        NotificationService::markAllAsRead(Auth::id());
        return back();
    }
}

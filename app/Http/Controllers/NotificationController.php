<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->unreadNotifications;
        
        if ($request->expectsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json(['data' => $notifications]);
        }

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if ($request->expectsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json(['message' => 'Notification marked as read']);
        }

        return redirect()->back();
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        if ($request->expectsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json(['message' => 'All notifications marked as read']);
        }

        return redirect()->back();
    }
}

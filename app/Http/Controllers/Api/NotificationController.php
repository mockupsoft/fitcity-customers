<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\UserDeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();
        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Auth::user()->notifications()->whereIn('id', $request->ids)->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function registerDevice(Request $request)
    {
        $validated = $request->validate(['token' => 'required|string']);

        UserDeviceToken::updateOrCreate(
            ['user_id' => Auth::id(), 'device_token' => $validated['token']]
        );

        return response()->json(['success' => true]);
    }
}


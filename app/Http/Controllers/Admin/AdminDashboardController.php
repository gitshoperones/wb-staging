<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminEmailNotification;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $admin_notifications = AdminEmailNotification::orderBy('id', 'DESC')->paginate(50);

        return view('admin.index', compact('admin_notifications'));
    }

    public function show($id, Request $request)
    {
        $admin_notification = AdminEmailNotification::findOrFail($id);

        return view('admin.admin-notification', compact('admin_notification'));
    }

    public function update($id, Request $request)
    {
        $admin_notification = AdminEmailNotification::findOrFail($id);
        $admin_notification->is_read = $request->is_read;
        $admin_notification->update();

        return response()->json(['message' => 'Success']);
    }
}

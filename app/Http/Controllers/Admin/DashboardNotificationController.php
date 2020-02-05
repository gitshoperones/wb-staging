<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DashboardNotification;

class DashboardNotificationController extends Controller
{
    public $dashboard_notification;

    function __construct()
    {
        $this->dashboard_notification = new DashboardNotification();
    }

    public function index()
    {
        $dashboard_notifications = $this->dashboard_notification->getAll();
        return view('admin.dashboard-notifications.index', compact('dashboard_notifications'));
    }

    public function edit($id)
    {
        $dashboard_notification = $this->dashboard_notification->getById($id);
        
        return view('admin.dashboard-notifications.edit', compact('dashboard_notification'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'subject' => 'required',
            // 'email_template_id' => 'required',
            'button' => 'required',
            // 'button2' => 'required',
            // 'frequencies' => 'required',
            // 'recipient' => 'required',
            'body' => 'required',
        ]);
        
        $data = $request->only([
            'subject',
            'email_template_id',
            'button',
            'button2',
            // 'frequencies',
            'body',
            'status'
        ]);

        if ($this->dashboard_notification->setUpdate($id, $data)) {
            return back()->with('success_message', "Successfully updated");
        } else {
            return back()->with('error', "Failed to update");
        }
    }

}

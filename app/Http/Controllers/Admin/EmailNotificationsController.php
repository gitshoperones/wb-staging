<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailNotification;
use App\Models\EmailTemplate;

class EmailNotificationsController extends Controller
{   
    public $email_notification;
    public $email_template;
    
    function __construct()
    {
        $this->email_notification = new EmailNotification();
        $this->email_template = new EmailTemplate();
    }

    public function index()
    {
        $email_notifications = $this->email_notification->getAll();
        return view('admin.email-notifications.index', compact('email_notifications'));
    }

    public function edit($id)
    {
        $email_notification = $this->email_notification->getById($id);
        $email_templates = $this->email_template->getAll();
        return view('admin.email-notifications.edit', compact('email_notification', 'email_templates'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'button' => 'required',
            // 'frequencies' => 'required',
            'body' => 'required',
        ]);
        
        $data = $request->only([
            'subject',
            'button',
            // 'frequencies',
            'body'
        ]);

        if ($this->email_notification->setUpdate($id, $data)) {
            return back()->with('success_message', "Successfully updated");
        } else {
            return back()->with('error', "Failed to update");
        }
    }
}

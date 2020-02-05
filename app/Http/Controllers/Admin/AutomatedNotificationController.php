<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DashboardNotification;
use App\Models\EmailNotification;
use App\Models\EmailTemplate;
use App\Models\NotificationEvent;
use Illuminate\Support\Collection;

class AutomatedNotificationController extends Controller
{
    public $dashboard_notification;
    public $email_notification;
    public $email_template;

    function __construct()
    {
        $this->dashboard_notification = new DashboardNotification();
        $this->email_notification = new EmailNotification();
        $this->email_template = new EmailTemplate();
    }

    public function index()
    {
        $dashboard_notification = new Collection($this->dashboard_notification->getAll());
        $email_notification = new Collection($this->email_notification->getAll());
        $merged_notifications = $dashboard_notification->merge($email_notification)
            ->groupBy('notification_event_id')
            ->sortBy(function($value, $key) {
                return $value[0]->notification_event->order;
            }
        );

        return view('admin.automated-notifications.index', compact('merged_notifications'));
    }

    public function edit($id)
    {
        $dashboard_notification = new Collection($this->dashboard_notification->getAll());
        $email_notification = new Collection($this->email_notification->getAll());
        $merged_notifications = $dashboard_notification->merge($email_notification)->where('notification_event_id', $id);
        $event = NotificationEvent::find($id);

        return view('admin.automated-notifications.edit', compact('merged_notifications', 'event'));
    }

    public function update($id, Request $request)
    {        
        $data = $request->only('description');

        if (NotificationEvent::find($id)->update($data)) {
            return back()->with('success_message', "Trigger description successfully updated.");
        } else {
            return back()->with('error', "Failed to update.");
        }
    }

    public function filterBy(Request $request)
    {
        $filtered_by = $this->getFilteredby($request->filter_by);
        return response()->json($filtered_by);
    }

    public function getFilteredby($filter_by)
    {
        if ($filter_by == 'all') {
            $dashboard_notification = new Collection($this->dashboard_notification->getAll());
            $email_notification = new Collection($this->email_notification->getAll());
        } else {
            $dashboard_notification = new Collection($this->dashboard_notification->getAllFilterBy($filter_by));
            $email_notification = new Collection($this->email_notification->getAllFilterBy($filter_by));
        }

        $merged_notifications = $dashboard_notification->merge($email_notification)
            ->groupBy('notification_event_id')
            ->sortBy(function($value, $key) {
                return $value[0]->notification_event->order;
            }
        );
        
        return $merged_notifications;
    }

    public function updateOrder(Request $request)
    {
        $eventIds = collect($request->eventIds)->map(function ($value) {
            return (int) str_replace('order_id_', '', $value);
        });
        
        foreach ($eventIds as $key => $id) {
            NotificationEvent::find($id)->update(['order' => $key]);
        }

        return response()->json([
            'success' => 'Update Success'
        ]);
    }
}

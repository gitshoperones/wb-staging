<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardNotification extends Model
{
    protected $fillable = [
        'notification_event_id',
        // 'email_template_id',
        'frequency',
        'subject',
        'body',
        'button',
        'button2',
        // 'recipient',
        'tokens_subject',
        'tokens_body',
        'type',
        'recipient',
        'status'
    ];

    public function getAll()
    {
        return self::all();
    }

    public function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public function setUpdate($id, $data)
    {
        return self::findOrFail($id)->update([
            'subject' => $data['subject'],
            // 'email_template_id' => $data['email_template_id'],
            'button' => $data['button'],
            'button2' => isset($data['button2']) ? $data['button2'] : null,
            // 'frequency' => implode(',', $data['frequencies']),
            // 'recipient' => $data['recipient'],
            'body' => $data['body'],
            'status' => (isset($data['status'])) ? ($data['status']) ? true : false : false
        ]);
    }

    public function notification_event()
    {
        return $this->belongsTo(NotificationEvent::class);
    }

    public function getAllFilterBy($filter_by)
    {
        return self::where('recipient', $filter_by)
            ->orWhere('recipient', 'like', '%' . $filter_by . '%')->get();
    }
}

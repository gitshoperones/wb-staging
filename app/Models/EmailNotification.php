<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    protected $fillable = [
        'notification_event_id',
        'email_template_id',
        'frequency',
        'subject',
        'body',
        'button',
        'tokens_subject',
        'tokens_body',
        'type',
        'recipient',
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
            'button' => $data['button'],
            // 'frequency' => implode(',', $data['frequencies']),
            'body' => $data['body'],
        ]);
    }

    public function notification_event()
    {
        return $this->belongsTo(NotificationEvent::class);
    }

    public function email_template()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
    
    public function getAllFilterBy($filter_by)
    {
        return self::where('recipient', $filter_by)
            ->orWhere('recipient', 'like', '%' . $filter_by . '%')->get();
    }
}

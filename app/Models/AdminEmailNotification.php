<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationEvent;
use App\Models\User;
class AdminEmailNotification extends Model
{
    protected $fillable = [
        'notification_event_id',
        'subject',
        'body',
        'is_read',
        'user_id'
    ];

    public function notification_event ()
    {
        return $this->belongsTo(NotificationEvent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

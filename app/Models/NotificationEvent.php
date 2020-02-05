<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationEvent extends Model
{
    protected $fillable = [
        'name', 'description', 'type', 'order' 
    ];

    public function email_notifications()
    {
        return $this->hasMany(EmailNotification::class);
    }

    public function dashboard_notifications()
    {
        return $this->hasMany(DashboardNotification::class);
    }

}

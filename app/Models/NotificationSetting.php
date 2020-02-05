<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'user_id', 'meta_key', 'meta_value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function isImmidiate(User $user)
    {
        $setting = $user->notificationSettings()->where('meta_key', 'all')->first();

        if (!$setting || $setting->meta_value === 'immediate') {
            return true;
        }

        return false;
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Couple extends Model
{
    protected $fillable = [
        'userA_id', 'userB_id', 'title', 'desc', 'services', 'profile_avatar', 'profile_cover',
        'onboarding', 'partner_firstname', 'partner_surname'
    ];

    public function getProfileAvatarAttribute($value)
    {
        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return Storage::url($value);
        }

        return $value;
    }

    public function getRawProfileAvatarFilename()
    {
        $parts = explode('/', $this->profile_avatar);

        return end($parts);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function userA()
    {
        return $this->belongsTo(User::class, 'userB_id', 'id');
    }

    public function userB()
    {
        return $this->belongsTo(User::class, 'userA_id', 'id');
    }
}

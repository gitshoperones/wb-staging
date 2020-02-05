<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsRecord extends Model
{
    protected $fillable = [
        'email', 'details', 'message', 
        'status'
    ];

    protected $casts = [
        'details' => 'array',
    ];

    protected $status = [
        1 => 'Open',
        2 => 'Complete'
    ];

    public function subscription()
    {
        return $this->hasOne(NewsLetterSubscription::class, 'email', 'email');
    }

    public function getStatusAttribute($value)
    {
        return $this->status[$value];
    }
}

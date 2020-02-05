<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsLetterSubscription extends Model
{
    protected $fillable = [
        'email'
    ];

    public function contactUsRecord()
    {
        return $this->belongsTo(ContactUsRecord::class, 'email');
    }
}

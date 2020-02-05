<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorEmail extends Model
{
    protected $fillable = [
        'user_id', 'email'
    ];

    protected $table = 'vendor_emails';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCardAccount extends Model
{
    protected $fillable = [
        'user_id', 'gateway_user_id', 'card_account_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}

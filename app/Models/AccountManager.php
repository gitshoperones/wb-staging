<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountManager extends Model
{
    protected $fillable = [
        'accnt_mngr_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userManager()
    {
        return $this->belongsTo(User::class, 'accnt_mngr_id');
    }
}

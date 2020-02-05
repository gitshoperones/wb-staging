<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayUser extends Model
{
    protected $fillable = [
        'user_id', 'gateway_user_id', 'gateway_company_id', 'gateway_bank_acct_id',
        'gateway_name',
    ];

    public function user()
    {
        return $this->belongsto(User::class)->withDefault();
    }

    public function cardAccounts()
    {
        return $this->hasMany(UserCardAccount::class);
    }
}

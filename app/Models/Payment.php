<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'invoice_id', 'milestone_ids', 'api_response_id', 'amount', 'status',
        'fee', 'tax',
    ];

    protected $casts = [
        'milestone_ids' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundRecord extends Model
{
    protected $fillable = [
        'invoice_id', 'status',
        'is_booking_canceled', 'reason',
        'user_id', 'amount'
    ];

    protected $statusValue = [
        1 => 'Pending',
        2 => 'Rejected',
        3 => 'Complete'
    ];
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function statusText()
    {
        return $this->statusValue[$this->status];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

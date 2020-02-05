<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'couple_id', 'vendor_id', 'job_quote_id', 'balance', 'total',
        'next_payment_date', 'status', 'amount', 'is_cancelled', 
        'cancelled_reason', 'is_refunded'
    ];

    protected $statusValue = [
        0 => 'unpaid',
        1 => 'deposit paid',
        2 => 'fully paid'
    ];

    protected $casts = [
        'specs' => 'array',
        'confirmed_dates' => 'array',
    ];

    public function setNextPaymentDateAttribute($value)
    {
        $this->attributes['next_payment_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString() : null;
    }

    public function getNextPaymentDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function jobQuote()
    {
        return $this->belongsTo(JobQuote::class)->withTrashed();
    }

    public function statusText()
    {
        return isset($this->statusValue[$this->status]) ? $this->statusValue[$this->status] : '';
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function couple()
    {
        return $this->belongsTo(Couple::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function refundRecord()
    {
        return $this->hasOne(RefundRecord::class);
    }
}

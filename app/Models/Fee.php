<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'gateway_fee_id', 'name', 'fee_type_id', 'amount', 'cap', 'min',
        'exp_date', 'status', 'type',
    ];

    protected $statusValue = [0 => 'inactive', 1 => 'active'];

    protected $feeTypes = [
        1 => 'Fixed', 2 => 'Percentage', 3 => 'Percentage with Cap', 4 => 'Percentage with Min'
    ];

    public function scopeTotalWedbookerFee($query)
    {
        // amount in cents so we need to divide it by 100.
        return $query->where('default', 1)->where('status', 1)->sum('amount') / 100;
    }

    public function feeTypeText()
    {
        return isset($this->feeTypes[$this->fee_type_id]) ? $this->feeTypes[$this->fee_type_id] : '';
    }

    public function getFeeTypes()
    {
        return $this->feeTypes;
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }

    public function getExpDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('F j, Y') : '';
    }

    public function setExpDateAttribute($value)
    {
        $this->attributes['exp_date'] = $value ? Carbon::createFromFormat('F j, Y', $value)
            ->toDateString() : null;
    }

    public function vendors()
    {
        return $this->belongsToMany(VendorFee::class);
    }
}

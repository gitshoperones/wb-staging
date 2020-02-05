<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorFee extends Model
{
    protected $fillable = ['vendor_id', 'fee_id'];

    public function fee()
    {
        return $this->hasOne(Fee::class, 'id', 'fee_id');
    }
}

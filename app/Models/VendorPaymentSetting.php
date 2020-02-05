<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPaymentSetting extends Model
{
    protected $fillable = [
        'vendor_id', 'bank', 'accnt_num', 'accnt_name',
        'bsb', 'accnt_type', 'holder_type', 'status',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

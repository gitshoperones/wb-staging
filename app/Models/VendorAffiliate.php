<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorAffiliate extends Model
{
    protected $fillable = ['parent_vendor_id', 'child_vendor_id'];

    public function parentVendorProfile()
    {
        return $this->belongsTo(Vendor::class, 'parent_vendor_id', 'id');
    }

    public function childVendorProfile()
    {
        return $this->belongsTo(Vendor::class, 'child_vendor_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteVendor extends Model
{
    protected $fillable = [
        'user_id', 'vendor_id'
    ];

    public function vendorProfile()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorVenueCapacity extends Model
{
    protected $fillable = ['vendor_id', 'capacity'];

    public function vendorVenue()
    {
        return $this->belongsTo(Vendor::class);
    }
}

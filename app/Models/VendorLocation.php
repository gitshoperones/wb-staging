<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorLocation extends Model
{
    protected $fillable = [
        'vendor_id', 'lat', 'lng', 'address'
    ];

    protected $table = 'vendor_locations';

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

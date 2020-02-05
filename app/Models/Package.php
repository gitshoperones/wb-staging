<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Package extends Model
{
    protected $fillable = [
        'vendor_id', 'media_id', 'subheading', 'filename', 'package_path'
    ];

    protected $table = 'vendor_packages';

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

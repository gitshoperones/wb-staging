<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Offer extends Model
{
    protected $fillable = [
        'vendor_id', 'heading', 'description', 'end_date'
    ];

    protected $table = 'vendor_offers';

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

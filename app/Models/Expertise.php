<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $fillable = [
        'icon', 'name',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function vendor()
    {
        return $this->belongsToMany(Vendor::class);
    }
}

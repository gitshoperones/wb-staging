<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'icon', 'name', 'state', 'abbr'
    ];

    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Location::class);
    }
}

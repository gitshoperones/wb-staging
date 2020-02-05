<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'order', 'icon', 'template', 'name',
    ];

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class);
    }

    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = str_replace("&", "and", $value);
    }

    public function jobPostTemplates()
    {
        return $this->belongsToMany(JobPostTemplate::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeautySubcategory extends Model
{
    protected $fillable = [
        'icon', 'name',
    ];

    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class);
    }
}

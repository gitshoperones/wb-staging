<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPostTemplate extends Model
{
    protected $fillable = ['title', 'body', 'custom_text', 'approximate', 'approxDisplay', 'fields', 'images_option'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

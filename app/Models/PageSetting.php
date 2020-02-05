<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PageSetting extends Model
{
    protected $metaTypes = [
        'text' => 1,
        'image' => 2,
        'file' => 3,
    ];

    protected $fillable = ['page_id', 'meta_type', 'meta_key', 'meta_value', 'order'];

    public function setMetaTypeAttribute($value)
    {
        $this->attributes['meta_type'] = $this->metaTypes[$value] ?? 1;
    }

    public function setMetaKeyAttribute($value)
    {
        $this->attributes['meta_key'] = strtolower($value);
    }

    public function getStyleImageUrlAttribute()
    {
        if (Storage::exists($this->meta_value))
            return 'style="background-image: url('. Storage::url($this->meta_value) . ')"';
        
        return null;
    }

    public function scopeFromPage($query, $name)
    {
        return $query->whereHas('page', function ($query) use ($name) {
            return $query->whereName($name);
        });
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'user_id', 'meta_key', 'meta_filename', 'meta_original_filename'
    ];

    public function getMetaFilenameAttribute($value)
    {
        return $value ? Storage::url($value) : $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobQuotes()
    {
        $this->belongsToMany(JobQuote::class);
    }
}

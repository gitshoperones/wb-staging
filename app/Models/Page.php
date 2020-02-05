<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['name'];

    public function pageSettings()
    {
        return $this->hasMany(PageSetting::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorMessages extends Model
{
    protected $fillable = [
        'code', 'default', 'original_message', 'custom_message'
    ];
}

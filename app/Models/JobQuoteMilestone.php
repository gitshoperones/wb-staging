<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class JobQuoteMilestone extends Model
{
    protected $fillable = [
        'job_quote_id', 'percent', 'due_date', 'desc', 'paid'
    ];

    protected $statusValue = [
        0 => 'unpaid',
        1 => 'paid',
    ];

    public function jobQuote()
    {
        return $this->belongsTo(JobQuote::class);
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString() : null;
    }

    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }
}

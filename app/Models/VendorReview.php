<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorReview extends Model
{
    protected $fillable = [
        'code', 'vendor_id', 'event_date', 'reviewer_name', 'reviewer_email', 'message',
        'rating', 'rating_breakdown', 'status', 'event_type',
    ];

    protected $casts = [
        'rating_breakdown' => 'array',
    ];

    public function setEventDateAttribute($value)
    {
        $this->attributes['event_date'] = !$value || $value === '-' ? null : $value;
    }

    public function getEventDateAttribute($value)
    {
        $values = explode('-', $value);
        $month = $values[0];
        $year = $values[1] ?? null;

        if ($month && $year) {
            $monthName = date("F", mktime(0, 0, 0, $month, 10));
            return sprintf('%s %s', $monthName, $year);
        }

        return '';
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

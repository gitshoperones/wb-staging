<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobQuote extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'job_post_id', 'message', 'specs', 'total', 'duration',
        'tc_file_id', 'confirmed_dates', 'apply_gst', 'locked', 'status',
        'amount', 'vendor_review_status',
    ];

    protected $statusValue = [
        0 => 'Draft',
        1 => 'Pending Response',
        2 => 'Request Changes',
        3 => 'Accepted',
        4 => 'Declined',
        5 => 'Expired',
        6 => 'Withdrawn',
    ];

    protected $casts = [
        'specs' => 'array',
        'confirmed_dates' => 'array',
    ];

    public function setDurationAttribute($value)
    {
        $this->attributes['duration'] = $value ? Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString() : null;
    }

    public function getDurationAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function statusText()
    {
        return isset($this->statusValue[$this->status]) ? $this->statusValue[$this->status] : '';
    }

    public function tcFile()
    {
        return $this->hasOne(File::class, 'id', 'tc_file_id');
    }

    public function milestones()
    {
        return $this->hasMany(JobQuoteMilestone::class);
    }

    public function additionalFiles()
    {
        return $this->belongsToMany(File::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}

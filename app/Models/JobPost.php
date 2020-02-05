<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'category_id', 'vendor_id', 'event_id', 'event_date', 'budget', 'number_of_guests',
        'time_required', 'required_address', 'specifics', 'shipping_address', 'completion_date',
        'job_time_requirement_id', 'beauty_subcategories_id', 'is_flexible', 'is_invite', 'status',
    ];

    protected $casts = [
        'other_requirements' => 'array',
        'shipping_address' => 'array',
    ];

    protected $stat = [
        'draft' => 0,
        'live' => 1,
        'closed' => 2,
        'guest' => 3,
        'expired' => 4,
        'pending' => 5,
    ];

    public function setNumberOfGuestsAttribute($value)
    {
        return $this->attributes['number_of_guests'] = (int) $value;
    }

    public function setEventDateAttribute($value)
    {
        $this->attributes['event_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString() : null;
    }

    public function getEventDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function setCompletionDateAttribute($value)
    {
        $this->attributes['completion_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString() : null;
    }

    public function getCompletionDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function getOtherRequirementsAttribute($value)
    {
        return $value ? json_decode($value) : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function timeRequirement()
    {
        return $this->hasOne(JobTimeRequirement::class, 'id', 'job_time_requirement_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }

    public function propertyTypes()
    {
        return $this->belongsToMany(PropertyType::class);
    }

    public function propertyFeatures()
    {
        return $this->belongsToMany(PropertyFeature::class);
    }

    public function quotes()
    {
        return $this->hasMany(JobQuote::class);
    }

    public function userProfile()
    {
        return $this->belongsTo(Couple::class, 'user_id', 'userA_id');
    }

    public function websiteRequirements()
    {
        return $this->belongsToMany(WebsiteRequirement::class);
    }

    public function beautySubcategory()
    {
        return $this->hasOne(BeautySubcategory::class, 'id', 'beauty_subcategories_id')->withDefault();
    }

    public function vendor_name($vendor_id)
    {
        return optional(Vendor::where('id', $vendor_id)->first())->business_name;
    }
}

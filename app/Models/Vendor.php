<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Vendor extends Model
{
    protected $fillable = [
        'user_id', 'business_name', 'trading_name', 'desc', 'abn', 'street',
        'city', 'state', 'postcode', 'website', 'profile_cover', 'profile_avatar', 'packages_price',
        'onboarding', 'gst_registered', 'invite_review_status', 'embedded_video'
    ];

    public function getDescAttribute($value)
    {
        return preg_replace("/'/", "&#39;", $value);
    }

    public function setDescAttribute($value)
    {
        return $this->attributes['desc'] = preg_replace("/'/", "&#39;", $value);
    }

    public function getProfileAvatarAttribute($value)
    {
        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return Storage::url($value);
        }

        return $value;
    }

    public function getRawProfileAvatarFilename()
    {
        $parts = explode('/', $this->profile_avatar);

        return end($parts);
    }

    public function getProfileCoverAttribute($value)
    {
        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return Storage::url($value);
        }

        return $value;
    }

    public function getRawProfileCoverFilename()
    {
        $parts = explode('/', $this->profile_cover);

        return end($parts);
    }

    public function media()
    {
        return $this->morphMany('App\Media', 'commentable');
    }

    public function getFeaturedImages()
    {
        return $this->hasMany(Media::class, 'commentable_id');
    }

    public function getFillableFields()
    {
        return $this->fillable;
    }

    public function getEmbeddedVideo()
    {
        $ids = [];
        $urls = explode(',', rtrim($this->embedded_video, ','));

        foreach ($urls as $url) {
            if (preg_match('/\byoutube\b/', $url)) {
                parse_str( parse_url( $url, PHP_URL_QUERY ), $id);
                $id_v = $id['v'] ?? 'not-found';
                $ids[] = '//www.youtube.com/embed/'.$id_v;
            }

            if (preg_match('/\byoutu.be\b/', $url) && !preg_match('/\byoutube\b/', $url)) {
                $id = parse_url( $url );
                $id_path = $id['path'] ?? 'not-found';
                $ids[] = '//www.youtube.com/embed'.$id_path;
            } 
            
            if (preg_match('/\bvimeo\b/', $url)) {
                $id = (int) substr(parse_url($url, PHP_URL_PATH), 1);

                $ids[] = 'http://player.vimeo.com/video/'.$id;
            }
        }

        return $ids;
    }

    public function getRawEmbeddedVideo()
    {
        return explode(',', rtrim($this->embedded_video, ','));    
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function expertise()
    {
        return $this->belongsToMany(Category::class, 'vendor_expertises');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id')->withDefault();
    }

    public function paymentSetting()
    {
        return $this->hasOne(VendorPaymentSetting::class)->withDefault();
    }

    public function propertyTypes()
    {
        return $this->belongsToMany(PropertyType::class);
    }

    public function propertyFeatures()
    {
        return $this->belongsToMany(PropertyFeature::class);
    }

    public function venueCapacity()
    {
        return $this->hasOne(VendorVenueCapacity::class)->withDefault();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function fee()
    {
        return $this->hasOne(VendorFee::class)->withDefault();
    }

    public function feeDetails()
    {
        return Fee::whereId($this->fee()->first()->fee_id)->firstOrFail();
    }

    public function reviews()
    {
        return $this->hasMany(VendorReview::class);
    }

    public function childVendors()
    {
        return $this->hasMany(VendorAffiliate::class, 'parent_vendor_id', 'id');
    }

    public function parentVendor()
    {
        return $this->belongsTo(VendorAffiliate::class, 'id', 'child_vendor_id');
    }

    public function offer()
    {
        return $this->hasOne(Offer::class);
    }

    public function package()
    {
        return $this->hasMany(Package::class);
    }

    public function vendor_location()
    {
        return $this->hasOne(VendorLocation::class);
    }
}

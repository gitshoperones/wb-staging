<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use App\Notifications\PasswordResetNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\NotificationContent;

class User extends Authenticatable
{
    use Notifiable;
    use Impersonate;

    protected $fillable = [
        'email', 'fname', 'lname', 'password', 'dob', 'phone_number',
        'note', 'account', 'account_manager', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $statusValue = [
        'pending' => 0,
        'active' => 1,
        'rejected' => 2,
        'archived' => 3,
        'pending email verification' => 4,
    ];

    protected $dates = [
        'created_at', 'updated_at', 'dob'
    ];

    public function sendPasswordResetNotification($token)
    {
        $email_notification = (new NotificationContent)->getEmailContent('Password reset', 'admin,parent,vendor,couple');
        $this->notify(new PasswordResetNotification($token, $email_notification));
    }

    public function setStatusAttribute($value)
    {
        $val = isset($this->statusValue[$value]) ? $this->statusValue[$value] : $this->statusValue['active'];

        return $this->attributes['status'] = $val;
    }

    public function getStatusAttribute($value)
    {
        return array_search($value, $this->statusValue);
    }

    public function setAccountAttribute($value)
    {
        return $this->attributes['account'] = strtolower($value);
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = bcrypt($value);
    }

    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = !$value || $value === '--' ? null : Carbon::parse($value)->toDateString();
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function expertise()
    {
        return $this->hasMany(Vendor::class);
    }

    public function newsLetter()
    {
        return $this->hasOne(NewsLetterSubscription::class, 'email', 'email');
    }

    public function vendorProfile()
    {
        return $this->hasOne(Vendor::class);
    }

    public function latestNote()
    {
        return $this->hasMany(UserNotes::class)->orderBy("created_at", "desc");
    }

    public function coupleA()
    {
        return $this->hasOne(Couple::class, 'userA_id', 'id');
    }

    public function coupleB()
    {
        return $this->hasOne(Couple::class, 'userB_id', 'id');
    }

    public function coupleProfile()
    {
        return Couple::where('userA_id', $this->id)->orWhere('userB_id', $this->id)->first();
    }

    public function hasProfile()
    {
        if ($this->account === 'couple') {
            return Couple::where('userA_id', $this->id)
                ->orWhere('userB_id', $this->id)->exists();
        }

        if ($this->account === 'vendor') {
            return Vendor::where('user_id', $this->id)->exists();
        }

        return false;
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function tcFiles()
    {
        return $this->hasMany(File::class)->where('meta_key', 'tc');
    }

    public function favoriteVendors()
    {
        return $this->hasMany(FavoriteVendor::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentGatewayUser()
    {
        return $this->hasOne(PaymentGatewayUser::class);
    }

    public function activationCode()
    {
        return $this->hasOne(UserActivationCode::class);
    }

    public function notificationSettings()
    {
        return $this->hasMany(NotificationSetting::class);
    }

    public function managedAccount()
    {
        return $this->hasMany(AccountManager::class, 'accnt_mngr_id');
    }

    public function manager()
    {
        return $this->hasOne(AccountManager::class, 'user_id');
    }

    public function cardAccounts()
    {
        return $this->hasMany(UserCardAccount::class);
    }

    public function emails()
    {
        return $this->hasMany(VendorEmail::class);
    }

    public function isDoneOnboarding()
    {
        if ($this->account === 'vendor') {
            return $this->vendorProfile->onboarding === 1;
        }

        $coupleProfile = $this->coupleProfile();

        return $coupleProfile && $coupleProfile->onboarding === 1;
    }

    public function jobQuotes()
    {
        return $this->hasMany(JobQuote::class);
    }
}

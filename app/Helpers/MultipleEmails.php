<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorEmail;

class MultipleEmails
{
    public function getMultipleEmails($user)
    {
        $vendorNotifyEmails = $user->emails->pluck('email');
        $vendorNotifyEmails->push($user->email);
        
        $parent = ($user->vendorProfile->parentVendor) ? VendorEmail::where('user_id', Vendor::find($user->vendorProfile->parentVendor->parent_vendor_id)->user_id)->first() : null ;

        if($parent) {
            $vendorNotifyEmails->push($parent->email);
        }

        return $vendorNotifyEmails->unique();
    }
}

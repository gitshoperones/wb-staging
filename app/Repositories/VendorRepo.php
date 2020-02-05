<?php

namespace App\Repositories;

use Bouncer;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Location;
use App\Models\Offer;
use App\Models\Package;
use App\Models\PropertyType;
use App\Models\PropertyFeature;
use App\Models\VendorLocation;
use App\Models\VendorVenueCapacity;
use App\Repositories\FileRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\MailChimp;

class VendorRepo
{
    public function create(array $data)
    {
        return Vendor::create($data);
    }

    public function update(array $data)
    {
        $vendor = Vendor::whereId($data['vendorId'])->firstOrFail();

        if (isset($data['expertises'])) {
            //Remove all current tags from Mailchimp
            (new MailChimp)->manageTag('vendor', $vendor->user->email, $vendor->expertise->pluck('name')->toArray(), 'inactive');
            
            $data['expertises'] = ($data['expertises'] == 'null') ? [] : json_decode($data['expertises']);
            $vendor->expertise()->sync(
                Category::whereIn('name', $data['expertises'])->get(['id'])->pluck('id')
            );    

            //Add new tags from Mailchimp
            (new MailChimp)->manageTag('vendor', $vendor->user->email, $data['expertises'], 'active');
        }

        if (isset($data['locations'])) {
            $vendor->locations()->sync(
                Location::whereIn('name', json_decode($data['locations']))->get(['id'])->pluck('id')
            );
        }

        if (isset($data['propertyTypes'])) {
            $vendor->propertyTypes()->sync(
                PropertyType::whereIn('name', json_decode($data['propertyTypes']))->get(['id'])->pluck('id')
            );
        }

        if (isset($data['propertyFeatures'])) {
            $vendor->propertyFeatures()->sync(
                PropertyFeature::whereIn('name', json_decode($data['propertyFeatures']))->get(['id'])->pluck('id')
            );
        }

        if (isset($data['venue_capacity'])) {
            VendorVenueCapacity::updateOrCreate(
                ['vendor_id' => $vendor->id],
                ['capacity' => $data['venue_capacity']]
            );
        }

        if(isset($data['no_end_date'])) {
            $end_date = ($data['no_end_date']) ? null : date_format(date_create($data['end_date']), 'Y-m-d') ;
        
            Offer::updateOrCreate(
                ['vendor_id' => $vendor->id],
                [
                    'heading' => $data['heading'],
                    'description' => $data['description'],
                    'end_date' => $end_date,
                ]
            );
        }

        if(isset($data['vendor_location'])) {
            VendorLocation::updateOrCreate(
                ['vendor_id' => $vendor->id],
                [
                    'lat' => $data['lat'],
                    'lng' => $data['lng'],
                    'address' => $data['address'],
                ]
            );
        }

        return $vendor->update($data);
    }

    public function updateProfileAvatar($file, Vendor $vendor)
    {
        if ($file) {
            $oldFile = $vendor->getRawProfileAvatarFilename();

            if ($vendor->profile_avatar && $oldFile) {
                Storage::delete(sprintf('user-uploads/%s', $oldFile));
            }

            return $vendor->update(['profile_avatar' => $this->upload($file)]);
        }
    }

    public function updateProfileCover($file, Vendor $vendor)
    {
        if ($file) {
            $oldFile = $vendor->getRawProfileCoverFilename();

            if ($vendor->profile_cover && $oldFile) {
                Storage::delete(sprintf('user-uploads/%s', $oldFile));
            }

            return $vendor->update(['profile_cover' => $this->upload($file)]);
        }
    }

    public function updatePackageDetails($packages, Vendor $vendor)
    {
        $packages = json_decode($packages, true);

        if (count($packages) > 0) {
            foreach ($packages as $package) {
                Package::where('id', $package['id'])->update(['subheading' => $package['value']]);
            }
            return true;
        }
    }

    public function updateTC($file, User $user)
    {
        if ($file) {
            return with(new FileRepo)->store($user->id, $file, 'tc');
        }
    }

    public function upload($file)
    {
        $staticFilename = request('staticFilename') && request('staticFilename') == true;

        if ($staticFilename) {
            return $file->storeAs(
                'user-uploads',
                $file->getClientOriginalName()
            );
        }

        return $file->store('user-uploads');
    }
}

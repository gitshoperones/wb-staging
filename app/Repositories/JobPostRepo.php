<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Media;
use App\Models\Couple;
use App\Models\Vendor;
use App\Models\JobPost;
use App\Models\Category;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\PropertyFeature;
use App\Models\WebsiteRequirement;
use App\Notifications\NewJobPosted;
use Illuminate\Support\Facades\Auth;
use App\Search\Vendor\VendorSearchManager;
use Illuminate\Support\Facades\Notification;

class JobPostRepo
{
    public function create(array $data)
    {
        if (Auth::user()->account === 'couple') {
            $couple = Couple::where('userA_id', Auth::user()->id)
                ->orWhere('userB_id', Auth::user()->id)
                ->firstOrFail(['id', 'userA_id', 'userB_id']);

            $userA = User::whereId($couple->userA_id)->first(['id']);
            $jobPost = $userA->jobPosts()->create($data);
        }

        if (Auth::user()->account === 'admin') {
            $jobPost = Auth::user()->jobPosts()->create($data);
        }
        
        $this->saveLocations($jobPost, $data['locations'] ?? null);
        $this->savePropertyTypes($jobPost, $data['property_types'] ?? null);
        $this->saveCustomFields($jobPost, $data['fields'] ?? null);
        $this->savePropertyFeatures($jobPost, $data['property_features'] ?? null);
        $this->saveWebsiteRequirements($jobPost, $data['website_requirements'] ?? null);
        $this->savePhotos($jobPost, $data['photos'] ?? null);
        $this->saveFlexiblility($jobPost, $data['flexible_date'] ?? null);
        $this->saveInvite($jobPost, $data['invite_favourite'] ?? null);
        $this->saveVendor($jobPost, $data['v_id'] ?? null);
        $this->saveJobType($jobPost, $data['v_id'] ?? null, $data['invite_favourite'] ?? null);

        return $jobPost;
    }

    public function saveLocations(JobPost $jobPost, $data)
    {
        if (!$data || count($data) < 1) {
            return $jobPost->locations()->sync([]);
        }

        $loc = Location::whereIn('name', $data)->pluck('id')->toArray();
        return $jobPost->locations()->sync($loc);
    }

    public function savePropertyTypes(JobPost $jobPost, $data)
    {
        if (!$data || count($data) < 1) {
            return $jobPost->propertyTypes()->sync([]);
        }

        $props = PropertyType::whereIn('name', $data)->pluck('id')->toArray();
        return $jobPost->propertyTypes()->sync($props);
    }

    public function saveCustomFields(JobPost $jobPost, $data)
    {
        if($data) {
            $jobPost->fields = json_encode($data);
            return $jobPost->save();
        }

        return true;
    }

    public function savePhotos(JobPost $jobPost, $photos)
    {
        if ($photos && count($photos) > 0) {
            foreach ($photos as $file) {
                $filename = $file->store('user-uploads');
                Media::create([
                    'commentable_id' => $jobPost->id,
                    'commentable_type' => get_class($jobPost),
                    'meta_key' => 'jobPostGallery',
                    'meta_filename' => $filename
                ]);
            }
        }
    }

    public function savePropertyFeatures(JobPost $jobPost, $data)
    {
        if (!$data || count($data) < 1) {
            return $jobPost->propertyTypes()->sync([]);
        }

        $props = PropertyFeature::whereIn('name', $data)->pluck('id')->toArray();
        return $jobPost->propertyFeatures()->sync($props);
    }

    public function saveWebsiteRequirements(JobPost $jobPost, $data)
    {
        if (!$data || count($data) < 1) {
            return $jobPost->websiteRequirements()->sync([]);
        }

        $sites = WebsiteRequirement::whereIn('name', $data)->pluck('id')->toArray();
        return $jobPost->websiteRequirements()->sync($sites);
    }

    public function saveFlexiblility(JobPost $jobPost, $data)
    {
        if($data) {
            $data = 1;
            $jobPost->is_flexible = $data;
            return $jobPost->save();
        }

        return true;
    }

    public function saveInvite(JobPost $jobPost, $data)
    {
        if($data) {
            $data = 1;
            $jobPost->is_invite = $data;
            return $jobPost->save();
        }

        return true;
    }

    public function saveVendor(JobPost $jobPost, $data)
    {
        if($data) {
            $jobPost->vendor_id = $data;
            return $jobPost->save();
        }

        return true;
    }

    public function saveJobType(JobPost $jobPost, $vendor_id, $invite)
    {
        if($vendor_id && $invite) {
            $jobPost->job_type = 2;
        }elseif($vendor_id) {
            $jobPost->job_type = 1;
        }else {
            $jobPost->job_type = 0;
        }

        return $jobPost->save();
        // return true;
    }

    public function update(array $data, $jobPost)
    {
        $this->saveLocations($jobPost, $data['locations'] ?? null);
        $this->savePropertyTypes($jobPost, $data['property_types'] ?? null);
        $this->saveCustomFields($jobPost, $data['fields'] ?? null);
        $this->savePropertyFeatures($jobPost, $data['property_features'] ?? null);
        $this->saveWebsiteRequirements($jobPost, $data['website_requirements'] ?? null);
        $this->savePhotos($jobPost, $data['photos'] ?? null);
        $this->saveFlexiblility($jobPost, $data['flexible_date'] ?? null);
        $this->saveInvite($jobPost, $data['invite_favourite'] ?? null);
        $this->saveVendor($jobPost, $data['v_id'] ?? null);

        return $jobPost->update($data);
    }
}

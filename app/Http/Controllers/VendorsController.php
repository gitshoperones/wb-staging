<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\FavoriteVendor;
use App\Repositories\MediaRepo;
use App\Repositories\VendorRepo;
use App\Helpers\MarkNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateVendorRequest;
use App\Search\Vendor\VendorSearchManager;
use App\Models\PageSetting;

class VendorsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favoriteVendors = [];

        if (request()->notificationId && $user) {
            (new MarkNotification)->asRead($user, request()->notificationId);
        }

        if ($user) {
            $favoriteVendors = $user->favoriteVendors()->pluck('vendor_id')->toArray();
        }

        $filters = (request()->keyword !== null) ? ['keyword' => request()->keyword, 'user_status' => 1] : request()->all() + ['user_status' => 1];
        $eagerLoads = ['expertise', 'states', 'locations'];

        $vendors = VendorSearchManager::applyFilters($filters, $eagerLoads)
            ->paginate(12);

        if(isset(request()->expertise) && gettype(request()->expertise) == 'array') {
            $categories = array_map('strtolower', str_replace(" ", "_", request()->expertise));
            $metas = [
                'keyword' => PageSetting::fromPage('Browse suppliers & venues')
                            ->where(function ($query) use($categories) {
                                for ($i = 0; $i < count($categories); $i++){
                                    $query->orwhere('meta_key', 'like',  '%' . $categories[$i] .'_keyword%');
                                }
                            })->pluck('meta_value')->toArray(),
                'description' => PageSetting::fromPage('Browse suppliers & venues')
                            ->where(function ($query) use($categories) {
                                for ($i = 0; $i < count($categories); $i++){
                                    $query->orwhere('meta_key', 'like',  '%' . $categories[$i] .'_description%');
                                }
                            })->pluck('meta_value')->toArray(),
                'title' => PageSetting::fromPage('Browse suppliers & venues')
                            ->where(function ($query) use($categories) {
                                for ($i = 0; $i < count($categories); $i++){
                                    $query->orwhere('meta_key', 'like',  '%' . $categories[$i] .'_title%');
                                }
                            })->pluck('meta_value')->toArray(),
            ];

            $metas['keyword'] = implode(', ', $metas['keyword']);
            $metas['description'] = implode(', ', $metas['description']);
            $metas['title'] = implode(', ', $metas['title']);
            
        }else {
            $metas = [
                'keyword' => PageSetting::fromPage('Browse suppliers & venues')->where('meta_key', 'meta_keyword')->pluck('meta_value')->first(),
                'description' => PageSetting::fromPage('Browse suppliers & venues')->where('meta_key', 'meta_description')->pluck('meta_value')->first(),
                'title' => PageSetting::fromPage('Browse suppliers & venues')->where('meta_key', 'meta_title')->pluck('meta_value')->first(),
            ];
        }

        $pageSettings = PageSetting::fromPage('Browse suppliers & venues')->get();

        return view('vendor-search.index', compact('vendors', 'favoriteVendors', 'pageSettings', 'metas'));
    }

    public function edit($vendorId)
    {
        if (request()->notificationId) {
            (new MarkNotification)->asRead(Auth::user(), request()->notificationId);
        }

        $userProfile = Vendor::whereId($vendorId)->with([
            'reviews' => function ($q) {
                return $q->where('status', 1);
            },
            'locations',
            'expertise',
            'propertyTypes',
            'venueCapacity',
            'propertyFeatures',
        ])->firstOrfail();

        if (Gate::denies('edit-profile', $userProfile)) {
            abort(403);
        }

        $this->shareProfileGallery($userProfile);
        $this->shareProfileFeatured($userProfile);

        $this->shareEditFlag();

        $vendorProfile = PageSetting::fromPage('Vendor Profile')->get();

        return view('profiles.edit-vendor', compact('userProfile', 'vendorProfile'));
    }

    public function show($vendorId)
    {
        $userProfile = Vendor::whereId($vendorId)->with([
            'reviews' => function ($q) {
                return $q->where('status', 1);
            },
            'locations',
            'expertise',
            'propertyTypes',
            'propertyFeatures'
        ])->firstOrfail();

        $reviews = $userProfile->reviews()->whereStatus(1)->orderBy('created_at', 'DESC')->paginate(5);

        $this->shareEditFlag('editOff');
        $this->shareProfileGallery($userProfile);
        $this->shareProfileFeatured($userProfile);

        if (Auth::user()) {
            $isFavorite = FavoriteVendor::where('user_id', Auth::id())
            ->where('vendor_id', $userProfile->id)->exists();
        } else {
            $isFavorite = false;
        }

        if ($userProfile->user_id === Auth::id() && !$userProfile->onboarding) {
            $showOnboarding = true;
        } else {
            $showOnboarding = false;
        }

        $pageSettings = PageSetting::fromPage('Vendor Signup')->get();
        $vendorProfile = PageSetting::fromPage('Vendor Profile')->get();

        // Check related vendors base on Location and Expertise
        $vendors = $this->getRelatedVendors($userProfile);
        $vendors = (count($vendors) < 4) ? $vendors->merge($this->getRelatedVendors($userProfile, 'locations')) : $vendors;
        $vendors = (count($vendors) < 4) ? $vendors->merge($this->getRelatedVendors($userProfile, 'expertise')) : $vendors;

        $vendors = $vendors->shuffle()->take(4);
        
        return view('profiles.show-vendor', compact(
            'userProfile',
            'isFavorite',
            'showOnboarding',
            'reviews',
            'pageSettings',
            'vendorProfile',
            'vendors'
        ));
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        if (Gate::denies('update-profile', $vendor)) {
            abort(403);
        }

        $vendorRepo = new VendorRepo;
        $vendorRepo->update($request->all() + ['vendorId' => $vendor->id]);
        $vendorRepo->updateProfileAvatar($request->profile_avatar, $vendor);
        $vendorRepo->updateProfileCover($request->profile_cover, $vendor);
        $vendorRepo->updatePackageDetails($request->packages, $vendor);
        $vendorRepo->updateTC($request->tc, Auth::user());

        $mediaRepo = new MediaRepo;
        $mediaRepo->updateSortingOrder(json_decode($request->gallerySorting));
        $mediaRepo->updateCaption(json_decode($request->galleryCaptions));
        $mediaRepo->updatePosition(json_decode($request->featuredPositions));
        $mediaRepo->updatePosition(json_decode($request->galleryPositions));

        if ($request->isJson() || $request->wantsJson()) {
            return response()->json();
        }

        return redirect(sprintf('vendors/%s', $vendor->id))
            ->with('success', 'Your profile was updated successfully!');
    }

    public function getRelatedVendors($data, $type = 'all')
    {
        if($type == 'locations') {
            $relatedVendors['locations'] = count($data->locations->pluck('name')->toArray()) ? $data->locations->pluck('name')->toArray() : null ;
        }elseif($type == 'expertise') {
            $relatedVendors['expertise'] = count($data->expertise->pluck('name')->toArray()) ? $data->expertise->pluck('name')->toArray() : null ;
        }else {
            $relatedVendors['expertise'] = count($data->expertise->pluck('name')->toArray()) ? $data->expertise->pluck('name')->toArray() : null ;
            $relatedVendors['locations'] = count($data->locations->pluck('name')->toArray()) ? $data->locations->pluck('name')->toArray() : null ;
        }
        
        $filters = $relatedVendors + ['user_status' => 1];
        $eagerLoads = ['expertise', 'locations'];

        $results = VendorSearchManager::applyFilters($filters, $eagerLoads)
            ->where('id', '<>', $data->id)->get();
            
        return $results;
    }
}

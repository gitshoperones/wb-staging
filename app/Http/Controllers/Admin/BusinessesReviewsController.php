<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessesReviewsController extends Controller
{
    public function index()
    {
        $businesses = Vendor::whereHas('user', function ($q) {
            $q->where('account', 'vendor');
        })->with([
            'user' => function ($q) {
                $q->addSelect(['id', 'email']);
            },
            'reviews' => function ($q) {
                $q->addSelect(['id', 'vendor_id', 'rating'])->whereStatus(1);
            }
        ])->paginate(10, ['id', 'user_id', 'business_name']);

        return view('admin.businesses-reviews.index', compact('businesses'));
    }

    public function show($vendorId)
    {
        $business = Vendor::whereId($vendorId)->firstOrFail(['id', 'business_name']);

        $reviews = VendorReview::where('vendor_id', $vendorId)->whereStatus(1)->paginate(10);

        return view('admin.businesses-reviews.show', compact('business', 'reviews'));
    }

    public function destroy($vendorId, $reviewId)
    {
        VendorReview::where('vendor_id', $vendorId)->whereId($reviewId)
            ->whereStatus(1)->firstOrFail()->delete();

        return redirect()->back()->with('success_message', 'Review deleted successfully!');
    }

    public function showReview($vendorId, $reviewId)
    {
        $review = VendorReview::where('vendor_id', $vendorId)->whereId($reviewId)
            ->whereStatus(1)->firstOrFail();

        return view('admin.businesses-reviews.show-review-details', compact('review'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\JobQuote;
use Illuminate\Support\Str;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use App\Mail\LowVendorReview;
use App\Mail\RequestForReview;
use Illuminate\Support\Carbon;
use App\Helpers\MarkNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Events\CoupleSubmittedNewReview;

class VendorReviewsController extends Controller
{
    public function create($code)
    {
        $review = VendorReview::whereCode($code)->with('vendor')->whereStatus(0)->first();

        if (request('job-quote-id')) {
            $jobQuote = JobQuote::whereId(request('job-quote-id'))->where('vendor_review_status', 0)->first();
            if (!$jobQuote) {
                abort(404, 'Sorry, you can only review this business once. Thanks for your review!');
            }
        }

        if (!$review) {
            abort(404, 'Sorry, you can only review this business once. Thanks for your review!');
        }

        return view('vendor-reviews.create', compact('review', 'code'));
    }

    public function store(Request $request)
    {
        if ($request->notificationId) {
            (new MarkNotification)->asRead($user, $request->notificationId);
        }

        if ($request->jobQuoteId) {
            $jobQuote = JobQuote::whereId($request->jobQuoteId)->where('vendor_review_status', 0)->firstOrFail();
        }

        $review = VendorReview::whereCode($request->code)->whereStatus(0)->firstOrFail();

        $review->event_type = $request->event_type;
        $review->message = $request->message;
        $review->rating = $request->rating;
        $review->event_date = $request->event_month.'-'.$request->event_year;
        $review->rating_breakdown = [
            'overall_satisfaction' => $request->overall_satisfaction,
            'easy_to_work_with' => $request->easy_to_work_with,
            'likely_to_recoment_to_a_friend' => $request->likely_to_recoment_to_a_friend,
        ];
        $review->status = 1;
        $review->save();

        if (isset($jobQuote) && $jobQuote) {
            $jobQuote->vendor_review_status = 1;
            $jobQuote->save();
        }

        event(new CoupleSubmittedNewReview($review));

        if ($request->rating <= 3) {
            Mail::to(config('mail.from.address'))->send(new LowVendorReview(
                Vendor::whereId($review->vendor_id)->with('user')->first(),
                $review
            ));
        }

        return view('vendor-reviews.confirmed');
    }

    public function requestReview(Request $request)
    {
        $user = Auth::user();
        $vendor = $user->vendorProfile;

        if ($request->notificationId) {
            (new MarkNotification)->asRead($user, $request->notificationId);
        }

        if ($request->couple1_email) {
            $review = $vendor->reviews()->create([
                'code' => Str::random(10).time(),
                'reviewer_email' => $request->couple1_email,
                'reviewer_name' => $request->couple1_name,
            ]);
            Mail::to($request->couple1_email)->send(new RequestForReview($review, $vendor));
        }

        if ($request->couple2_email) {
            $review = $vendor->reviews()->create([
                'code' => Str::random(10).time(),
                'reviewer_email' => $request->couple2_email,
                'reviewer_name' => $request->couple2_name,
            ]);
            Mail::to($request->couple2_email)->send(new RequestForReview($review, $vendor));
        }

        $vendor->invite_review_status = 1;
        $vendor->save();

        return redirect()->back()->with('success_review', 'Request for review sent!');
    }

    public function submitReview(Request $request)
    {
        if ($request->notificationId) {
            (new MarkNotification)->asRead($user, $request->notificationId);
        }

        $jobQuote = JobQuote::whereId($request->jobQuoteId)->with(['user.vendorProfile', 'jobPost'])
            ->where('vendor_review_status', 0)->first();

        if (!$jobQuote) {
            abort(404, 'Sorry, you can only review this business once. Thanks for your review!');
        }

        $review = $jobQuote->user->vendorProfile->reviews()->create([
            'code' => Str::random(10).time(),
            'reviewer_email' => Auth::user()->email,
            'reviewer_name' => Auth::user()->coupleProfile()->title,
            'message' => $request->message,
            'event_type' => $request->event_type,
            'rating' => $request->rating,
            'event_date' => Carbon::createFromFormat('d/m/Y', $jobQuote->jobPost->event_date)->format('m-Y'),
            'rating_breakdown' => [
                'overall_satisfaction' => $request->overall_satisfaction,
                'easy_to_work_with' => $request->easy_to_work_with,
                'likely_to_recoment_to_a_friend' => $request->likely_to_recoment_to_a_friend,
            ],
            'status' => 1
        ]);

        event(new CoupleSubmittedNewReview($review));

        $jobQuote->vendor_review_status = 1;
        $jobQuote->save();

        if ($request->rating <= 3) {
            Mail::to(config('mail.from.address'))->send(new LowVendorReview(
                Vendor::whereId($review->vendor_id)->with('user')->first(),
                $review
            ));
        }

        return redirect()->back()->with(
            'success_review',
            'Thanks for your review! This helps other couples to book the best businesses for their big day!'
        );
    }
}

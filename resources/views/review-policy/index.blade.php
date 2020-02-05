@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker helps Couples to efficiently book talented Suppliers and beautiful Venues around Australia. The first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place."}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "Content Policy"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-privay-policy" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'Review Policy' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Andreas Holm' }}</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px 0px;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="about-content text-justify">
				@if (optional($pageSettings->firstWhere('meta_key', 'section_text'))->meta_value)
					{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value !!}
				@else
					<p><strong>How do reviews work?</strong></p><p>Except for the first two reviews, which we permit for Suppliers &amp; Venues to source (if they wish) from previous wedding work prior to joining wedBooker, all reviews on wedBooker are written Couples from our community.</p><p>Reviews open for Couple’s to post on a Supplier/Venue immediately after confirming their booking of the Supplier/Venue.&nbsp; If no review has been provided 7 days after the event date, wedBooker sends a reminder to the Couple encouraging them to review the Supplier/Venue.</p><p><strong>Writing a review</strong></p><p>To leave a review on a Supplier/Venue, simply click on the notification of “Review Supplier/Venue” in your dashboard. Please note that reviews are limited to 350 words and must be in accordance with wedBooker’s Content Policy.</p><p>Our community relies on honest, transparent reviews. We will&nbsp;remove a review if we find that it violates this Policy, the Content Policy or wedBooker’s <a href="https://wedbooker.com/terms-and-conditions" data-mce-href="https://wedbooker.com/terms-and-conditions">Terms and Conditions</a>. &nbsp;wedBooker also reserves the right to delete a User’s account in accordance with wedBooker’s <a href="https://wedbooker.com/terms-and-conditions" data-mce-href="https://wedbooker.com/terms-and-conditions">Terms and Conditions</a>.</p><p><strong>Suppliers/Venues can check reviews</strong></p><p>wedBooker will notify a Supplier/Venue once their business has received a review. wedBooker encourages businesses to check the reviews they receive. If a Supplier/Venue believes that a review posted is not in accordance with wedBooker’s Content Policy, this Policy, wedBooker’s <a href="https://wedbooker.com/terms-and-conditions" data-mce-href="https://wedbooker.com/terms-and-conditions">Terms and Conditions</a> then the business should contact wedBooker immediately <a href="https://wedbooker.com/contact-us" data-mce-href="https://wedbooker.com/contact-us">here</a>.</p><p>If a Review provided is 3 stars or below, wedBooker is notified and will check that the business is delivering the services required of wedBooker’s professional community. Please see wedBooker’s <a href="https://wedbooker.com/terms-and-conditions" data-mce-href="https://wedbooker.com/terms-and-conditions">Terms and Conditions</a> regarding wedBooker’s ability to remove Suppliers/Venues from the platform.</p><p><strong>Ratings</strong></p><p>As part of the reviews process, Couple’s are encouraged to provide a star rating to the Supplier/Venue across 4 areas.&nbsp; This rating is then averaged to provide the Supplier/Venue with an overall rating for that job.</p><p>Suppliers/Venues are also provided with an overall star rating on the front of their profile, which is an aggregate of all of the ratings provided for that Supplier/Venue. Where no ratings have been provided, the Supplier/Venue will have a “New to wedBooker” badge.</p><p><strong>Other avenues to provide feedback</strong></p><p>In addition to wedBooker’s Ratings &amp; reviews, Couples can provide private feedback to Suppliers/Venues (via the private messaging system). wedBooker also encourages all users to provide feedback on the marketplace, which can be provided <a href="https://wedbooker.com/contact-us" data-mce-href="https://wedbooker.com/contact-us">here</a>.</p><p><br></p><p><br></p>
				@endif
			</div>
		</div>
	</div>
</section>
@endsection

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection
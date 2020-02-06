@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($vendorProfile->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($vendorProfile->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding, vendors"}}" />
	<meta name="description" content="{{ ($vendorProfile->firstWhere('meta_key', 'meta_description')) ? strip_tags($vendorProfile->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker is an online market network helping Couples to efficiently book Suppliers and Venues"}}"/>
	<meta name="title" content="{{ ($vendorProfile->firstWhere('meta_key', 'meta_title')) ? strip_tags($vendorProfile->firstWhere('meta_key', 'meta_title')->meta_value) : "wedBooker"}}">
@endsection

@section('content')
	<div class="wb-bg-grey">
		<div class="container">
			<div id="wb-dashboard">
				@include('modals.alert-messages')
				
				@include('partials.profiles.vendor-header')

				@include('partials.profiles.expertise')
				
                @include('partials.profiles.featured-images')

				@include('partials.profiles.offers')

				@include('partials.profiles.description')

				@include('partials.profiles.google-reviews')

				@include('partials.profiles.packages')
				
				@include('partials.profiles.gallery')
				
				@include('partials.profiles.videos')

				@include('partials.profiles.vendor-location')

				@include('partials.profiles.vendor-detailed-reviews')

			</div>
		</div>
		
		@include('partials.profiles.vendor-footer')

		@include('partials.profiles.related-vendors')
		
	</div>
	

	@if (request('status') && request('status') === 'pending' && Auth::check() && Auth::user()->status === 'pending')
		@include('modals.success-modal', [
			'header' => 'Your profile has been saved',
            'btnLabel' => 'Go to my dashboard',
            'btnUrl' => url('/dashboard'),
			'message' => 'Thanks for applying to list your business with wedBooker. Your profile is being reviewed by a member of our team. We will be in touch shortly.',
		])
	@endif
    @if(session()->has('success_review'))
        @include('modals.success-modal', [
            'header' => '',
            'message' => session('success_review'),
        ])
    @endif
	@if ($showOnboarding)
        @include('onboarding.vendor')
	@endif
@endsection

@push('css')
<style>
#wb-dashboard {
	margin-bottom: 95px;
}
.wb-notes-dashboard, .wb-gallery, .wb-profile-videos {
	padding: 55px 55px 65px;
    background-color: #fcfaf7;
}
.wb-gallery, .wb-gallery .grid {
    background-color: #e7d8d1;
}
.wb-cover div.name, .wb-cover-couple div.name, .wb-cover-vendor div.name, .wb-cover-quote div.name {
	font-size: unset;
	color: unset;
	text-transform: unset;
	font-weight: unset;
}
.wb-cover-vendor .name span.editOff {
	font-size: 23px;
    color: #fff;
    text-transform: uppercase;
    font-weight: 700;
}
</style>
@endpush
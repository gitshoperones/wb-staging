@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding, fees"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker is an online market network helping Couples to efficiently book Suppliers and Venues"}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-about" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'FEES' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Elin Bandmann' }}</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px 0px;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="about-content text-center">
				@if (optional($pageSettings->firstWhere('meta_key', 'section_text'))->meta_value)
					{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value !!}
				@else
					<p>wedBooker's core mission is to create a platform that helps Couples to book their wedding without limits, and for professional wedding businesses to win the work they deserve. As such, our payment model is fully transparent, and has been structured to suit our mission. </p>

					<p>There are <b><u>no fees</u></b> of any sort for Couples to book with wedBooker. </p>

					<p>For businesses, there are no fees to advertise, quote and win work, you simply need to cover the small payment gateway fee of 1.2% on jobs you win. It's that simple.</p>

					<p>We often get asked if we are planning to introduce booking fees. This is not currently in the plan, and what we can assure you is:</p>

					<p>
						1. There are <b><u>no fees</u></b> except for the small Payment Gateway fee of 1.2% that our businesses are required to cover on their bookings. This will be the case for the foreseeable future – we are focused on creating a truly valuable marketplace for our Couples and businesses <br />
						2. If we introduce a booking fee, our wedBooker businesses will be the first to know about it <br />
						3. There are no lock in periods, so you can decide if wedBooker suits your business at any point in time <br />
						4. We are fully transparent with our Couples and businesses and always will be. There will never be any hidden fees for either Couples or businesses.
					</p>
				@endif
			</div>
		</div>
	</div>
</section>

@guest
	<section class="wb-block danger-bg coral-banner">
		<div class="coral-image">
			<img data-src="{{ ($result = $pageSettings->firstWhere('meta_key', 'coral_img')) ? Storage::url($result->meta_value) : asset('assets/images/banners/guest.png') }}" class="img-responsive lazy" alt="">
		</div>
		<div class="row d-flex">
			<div class="col-md-2 col-sm-4 col-xs-12">
				<img src="{{ ($result = $pageSettings->firstWhere('meta_key', 'coral_img')) ? Storage::url($result->meta_value) : asset('assets/images/banners/guest.png') }}" class="img-responsive coral-inner-img" alt="">
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<h1 class="text">{!! optional($pageSettings->firstWhere('meta_key', 'coral_text'))->meta_value ? strip_tags($pageSettings->firstWhere('meta_key', 'coral_text')->meta_value) : 'Get Started With wedBooker Today' !!}</h1>
			</div>
			<div class="col-md-2 col-sm-6 col-xs-12">
				<a {!! ($pageSettings->firstWhere('meta_key', 'coral_button_link')) ? 'href=' . url(strip_tags($pageSettings->firstWhere('meta_key', 'coral_button_link')->meta_value)) : 'data-toggle=modal data-target=#start-planning-select' !!} class="btn btn-lg btn-danger">{!! $pageSettings->firstWhere('meta_key', 'coral_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'coral_button')->meta_value) : 'Sign Up Now' !!}</a>
			</div>
		</div>
	</section>
@endguest

@endsection

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection
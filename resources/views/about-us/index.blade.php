@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker helps Couples to efficiently book talented Suppliers and beautiful Venues around Australia. The first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place."}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "About wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-about" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'About Wedbooker' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Elin Bandmann' }}</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px 0px;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="about-content text-center">
				{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value ?? '' !!}
			</p>
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
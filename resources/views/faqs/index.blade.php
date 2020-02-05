@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding, FAQs"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "Looking for help? Read our FAQs to learn more about wedBooker"}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-faqs" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'Frequently Asked Questions' !!}</h1>
	</div>
	<div class="caption">{!! $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Mint Photography' !!}</div><!-- /.caption -->
</div>
<section id="wb-faq" class="wb-faq wb-bg-grey">
	<div>
		<div class="row text-center header-page inline">
			<div class="col-xs-12">
				<div class="wb-action-buttons">
					<a href="#couples" data-toggle="tab" class="btn btn-lg btn-orange">COUPLES</a>
					<a href="#vendors" data-toggle="tab" class="btn btn-lg btn-orange inactive">Businesses</a>
				</div>
			</div>
		</div>
		<div class="tab-content">
			@include('faqs.couple')
			@include('faqs.vendor')
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

@push('scripts')
<script>
	$('#vendors a[data-toggle="collapse"]').on('click', function(event) {
		var id = $(this).attr('href');

		$('.panel-collapse').not(id).removeClass('in');
		$('.panel-heading a, panel-collapse').attr('aria-expanded', 'false');
	});
</script>
@endpush

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection
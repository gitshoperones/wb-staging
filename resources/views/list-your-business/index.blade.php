@extends('layouts.public')
 
@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker is an online market network helping Couples to efficiently book Suppliers and Venues"}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-about" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'List your Business with wedBooker' !!}</h1>
	</div>
	<div class="caption">{!! $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Elin Bandmann' !!}</div><!-- /.caption -->
</div>

<section id="wb-list-how">
	<div class="container">
		<div class="row">
			@foreach (['left', 'middle', 'right'] as $item)
				<div class="col-xs-12 col-sm-4 col-md-4 wb-content">
					<div class="item">
						<img src="{{ ($result = $pageSettings->firstWhere('meta_key', "how_{$item}_img")) ? Storage::url($result->meta_value) : '' }}" class="wb-icon" />
						<p class="wb-lead">{!! $pageSettings->firstWhere('meta_key', "how_{$item}_title")['meta_value'] ? strip_tags($pageSettings->firstWhere('meta_key', "how_{$item}_title")['meta_value']) : '' !!}</p>
						<p class="wb-details">{!! $pageSettings->firstWhere('meta_key', "how_{$item}_text")['meta_value'] ? strip_tags($pageSettings->firstWhere('meta_key', "how_{$item}_text")['meta_value']) : '' !!}</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<section id="wb-list">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="list-content text-center text-primary">
				@if (optional($pageSettings->firstWhere('meta_key', 'section_text'))->meta_value)
					{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value !!}
				@else
					<p>Information about becoming a business...</p>
				@endif
			</div>
			<div class="text-center">
                <div id="wb-action-buttons">
                    <a href="{{ url('/sign-up?type=vendor') }}" class="btn btn-lg btn-danger">{!! $pageSettings->firstWhere('meta_key', 'list_button_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'list_button_text')->meta_value) : 'Apply Now!' !!}</a>
                </div>
            </div>
		</div>
	</div>
</section>

<section id="wb-reasons">
	<div class="container">
		@if (optional($pageSettings->firstWhere('meta_key', 'reason_title'))->meta_value)
			<h2>{!! strip_tags($pageSettings->firstWhere('meta_key', 'reason_title')->meta_value) !!}</h2>
		@else
			<h2>A few more reasons to list your business</h2>
		@endif

		<div class="item-inner">
			<div class="row d-flex">
				@foreach($reasons['title'] as $key => $reasonT)
					<div class="col-md-3 col-sm-12">
						<img src="@foreach($reasons['img'] as $reasonImg){!! (substr($reasonImg->meta_key, strpos($reasonImg->meta_key, "_") + 1) == substr($reasonT->meta_key, strpos($reasonT->meta_key, "_") + 1)) ? Storage::url($reasonImg->meta_value) : "" !!}@endforeach" class="wb-icon img-responsive">
						<strong class="wb-lead">{!! strip_tags($reasonT->meta_value) !!}</strong>
					</div>
				@endforeach
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
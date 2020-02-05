@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "Learn more about how couples and wedding businesses are using wedBooker!"}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-how-it-works" style="background-image: url({{ ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? Storage::url($result->meta_value) : '' }})">
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'How WedBooker Works' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Andreas Holm' }}</div><!-- /.caption -->
</div>
<section class="section-howItWorks" style="padding: 40px 0 0">
	<div class="text-center">
		<div class="">
			<div class="">
				<div class="tab-content">
					<div class="tab-pane" id="couple">
						<div class="container">
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1">
									@include('how-it-works.couple')
								</div>
							</div>
						</div>

						{{-- @guest
						<section class="wb-block danger-bg" style="margin-top: 40px">
							<h1 class="text" style="margin-bottom: 30px">{!! $pageSettings->firstWhere('meta_key', 'coral_text')->meta_value ?? 'Start Booking Your Wedding' !!}</h1>
							<a {!! ($pageSettings->firstWhere('meta_key', 'coral_button_link')) ? 'href=' . url(strip_tags($pageSettings->firstWhere('meta_key', 'coral_button_link')->meta_value)) : 'data-toggle=modal data-target=#start-planning-select' !!} class="btn btn-lg btn-danger">{!! $pageSettings->firstWhere('meta_key', 'coral_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'coral_button')->meta_value) : 'Sign Up Now' !!}</a>
						</section>
						@endguest --}}
					</div>

					<div class="tab-pane" id="vendor">
						<div class="container">
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1">
									@include('how-it-works.vendor')
								</div>
							</div>
						</div>
					</div>
				</div>
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
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            @if (request()->path() === 'how-it-works-businesses')
				setTimeout(function(){
                    $('#vendor').fadeIn(2000);
                }, 1000);
            @else
                setTimeout(function(){
                    $('#couple').fadeIn(2000);
                }, 1000);
            @endif
        });
    </script>
@endpush

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection
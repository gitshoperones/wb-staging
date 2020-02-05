@extends('layouts.public')

@push('css')
<style>
.input-bordered input, .selectdropdown dt a {
	border: 1px solid #ccd0d2;
}
</style>
@endpush

@section('meta')
<meta name="keywords" content="{{ (isset($metas['keyword']) && !empty($metas['keyword'])) ? strip_tags($metas['keyword']) : "wedBooker, business wedBooker"}}" />
	<meta name="description" content="{{ (isset($metas['description']) && !empty($metas['description'])) ? strip_tags($metas['description']) : "wedBooker is an online market network helping Couples to efficiently book Suppliers and Venues"}}"/>
	<meta name="title" content="{{ (isset($metas['title']) && !empty($metas['title'])) ? strip_tags($metas['title']) : "wedBooker"}}">

	<!-- Add the slick-theme.css if you want default styling -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<!-- Add the slick-theme.css if you want default styling -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
	<style>
		.slick-prev {
			width: 20%;
			left: 0;
			z-index: 999;
			height: 100%;
			display: none !important;
		}
		.slick-next {
			width: 20%;
			right: 0;
			height: 100%;
			display: none !important;
		}
		.feature-images:hover .slick-arrow {
			display: inline-block !important;
		}
	</style>
@endsection

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection

@section('content')
<div class="wb-small-banner wd-suppliers" style="background: url({{ ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? Storage::url($result->meta_value) : '' }})">
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'SUPPLIERS & VENUES' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Zoe Morley Photography' }}</div><!-- /.caption -->
</div>
<section class="section-suppliers-venues text-center wb-bg-grey" style="padding: 15px 0px;">
	<div class="container">
		<div class="section-content">
			<header class="section-header"></header>
        		<div class="section-item venues-search text-left">
                    @include('partials.alert-messages')
					<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#search-section" aria-expanded="false" aria-controls="search-section">
						Filter
					</button>
					<div class="collapse" id="search-section">
						<div class="card card-body" style="margin-top:15px;">
							@include('partials.vendor-search.search-form')
						</div>
					</div>

        			<div class="items" style="margin-top: 0px;">
						@forelse($vendors->getCollection()->shuffle() as $vendor)
        				<div class="item">
        					<div class="user-card">
								<div class="feature-images">
									<div class="card-image vendor-profile"
										data-link="{{ url(sprintf('vendors/%s', $vendor->id)) }}"
										style="background-image: url({{ $vendor->profile_avatar }});">
									</div>
									@if(!is_null($vendor->getFeaturedImages))
										@foreach($vendor->getFeaturedImages as $featured_image)
											<div
											class="card-image vendor-profile"
												style="
													background-image: url({{ $featured_image->getFileUrl() }});
													background-size: cover;
													background-position: center center;
													background-repeat: no-repeat;"
													data-link="{{ url(sprintf('vendors/%s', $vendor->id)) }}">
											</div>
										@endforeach
									@endif
								</div>

                                <div class="card-body snv-page" style="{{ (isset($vendor->offer) && ((!$vendor->offer->heading==null || !$vendor->offer->description==null) && ($vendor->offer->end_date === null || \Carbon\Carbon::parse($vendor->offer->end_date) > now()->subDays(1)))) ? "background-image: url('/assets/images/wedbooker-offer.png')" : "" }}">
                                    <div class="desc text-case-up text-color-primary">
                                        <a href="{{ url(sprintf('vendors/%s', $vendor->id)) }}">
                                        {{ $vendor->business_name }}
                                        </a>
									</div>
									@include('vendor-search.vendor-stars', $vendor)
        							<small class="desc text-bold div-block text-color-primary desc-locs">
        								{{ $vendor->expertise->implode('name', ', ') }}
        							</small>
        							<div class="location tooltip-holder">
        								<span class="pull-left">
										@if(!request()->locations)
											{{
												isset($vendor->locations[0])
												? $vendor->locations[0]->name
												: ''
											}}
											</span>
											<br/>
											@if(count($vendor->locations) > 1)
												{{ count($vendor->locations) - 1 }} more locations
												<div class="tooltip-alt" style="padding: 10px;">
													Service regions:
													{{
														$vendor->locations->forget(0)->map(function ($item) {
															return ['d' => $item['name']];
														})->implode('d', ', ')
													}}
												</div>
											@endif
										@else
											@php
												$reqLoc = $vendor->locations->whereIn('name', request()->locations)->first();
												$wideLoc = (!$reqLoc) ? $vendor->locations->where('name', 'Australia Wide')->first() : null ;
												$firstLoc = ($reqLoc) ? $vendor->locations->where('id', $reqLoc['id'])->keys()->first() : $vendor->locations->where('id', $wideLoc['id'])->keys()->first() ;
											@endphp
											{{
												isset($reqLoc)
												? $reqLoc['name']
												: $wideLoc['name']
											}}
											</span>
											@if(count($vendor->locations) > 1)
												<br/>
												{{ count($vendor->locations) - 1 }} more locations
												<div class="tooltip-alt" style="padding: 10px;">
													Service regions:
													{{
														$vendor->locations->forget($firstLoc)->map(function ($item) {
															return ['d' => $item['name']];
														})->implode('d', ', ')
													}}
												</div>
											@endif
										@endif
        							</div>
        							<small class="desc pull-left div-block text-color-primary text-light">
        								@couple
        								<span class="front-fav desc pull-right">
        									<favorite-vendor vendor-id="{{ $vendor->id }}"
                                                favorited="{{ in_array($vendor->id,$favoriteVendors) }}"></favorite-vendor>
        								</span>
        								@endcouple
									</small>
									@if (Auth::check())
										@couple
											<a href="{{ url(sprintf('dashboard/job-posts/create?vendor_id=%s', $vendor->id)) }}" class="btn btn-orange request-quote btn-snv">
												Request Quote
											</a>
										@endcouple
									@else
										<a href="{{ '/job-posts/create?vendor_id=' . $vendor->id }}" class="btn btn-orange request-quote btn-snv">Request Quote</a>
									@endif
        						</div>
        					</div>
						</div>
						
						@empty
						<p class="text-primary text-center" style="margin-top: 15px;">We don’t have the right business for you just yet. We love working with couples to find new wedding businesses in new locations. Contact us at hello@wedBooker.com and we can help you find what you need for your wedding in this location!</p>
        				@endforelse
        			</div>
        			<div class="pagination-wrap">
        				{{ $vendors->appends(request()->all())->links() }}
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
	<script>
        $('.vendor-profile').on('click', function(e){
            e.preventDefault();
            window.location = $(this).data('link');
        })
		cardwidth =  $('.venues-search .card-image').outerWidth();
		$('.venues-search .card-image').css({
			height: cardwidth+'px'
		});

		$( window ).resize(function() {
		  cardwidth =  $('.venues-search .card-image').outerWidth();
		  $('.venues-search .card-image').css({
				height: cardwidth+'px'
			});
		});
	</script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.feature-images').slick({
				dots: false,
				infinite: true,
				speed: 500,
				fade: true,
				cssEase: 'linear',
				lazyLoad: 'ondemand',
			});
		});
	</script>
@endpush

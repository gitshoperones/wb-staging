 @extends('layouts.dashboard')

@section('content')
	<section class="content dashboard-container">
		{{-- <div class="venues-search">
			@include('partials.vendor-search.search-form', [
				'url' => url('dashboard/favorite-vendors'),
				'hideMoreFilters' => true
			])
		</div> --}}
		@if(count($favoriteVendors) > 0)
		<div class="wb-favourites">
			<p class="text-primary" style="color: #353554;">When you post a job, we will make sure your favourite businesses are invited to quote first</p>
			<div class="favourites-wrapper">
				@foreach($favoriteVendors as $vendor)
				<div class="item">
					<div class="user-card">
						<div class="card-image" style="background: url({{ $vendor->vendorProfile->profile_avatar }}) 0% 0% / 100%;">
							<div class="card-hover">
								<a href="{{ url(sprintf('/vendors/%s', $vendor->vendor_id))}}" class="btn btn-outline">VIEW PROFILE</a>
							</div>
						</div>
						<div class="card-body">
							<favorite-vendor vendor-id="{{ $vendor->vendor_id }}" favorited="true"></favorite-vendor>
							<small class="desc">{{ $vendor->vendorProfile->business_name }}</small>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<div class="row">
				<div class="wb-pagination-block">
					{{ $favoriteVendors->appends([
							'keyword' => request('keyword'),
						])->links()
					}}
				</div>
			</div>
		</div>
		@else
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="text-center">
						<h3 style="line-height: initial;">No favourite businesses found.</h3>
					</div>
				</div><!-- /.col-md-8 -->
			</div><!-- /.row -->
		@endif
	</section>
@endsection

@push('scripts')
	<script>
		cardwidth =  $('.favourites-wrapper .card-image').outerWidth();
		$('.favourites-wrapper .card-image').css({
			height: cardwidth+'px'
		});

		$( window ).resize(function() {
		  cardwidth =  $('.favourites-wrapper .card-image').outerWidth();
		  $('.favourites-wrapper .card-image').css({
				height: cardwidth+'px'
			});
		});
	</script>
@endpush
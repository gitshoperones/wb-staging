@extends('layouts.dashboard')

@section('content')
	@if(session()->has('modal_message'))
		@include('modals.success-modal', [
			'header' => 'Quote Submitted',
			'message' => session('modal_message'),
			'btnLabel' => 'My Dashboard',
			'btnUrl' => url('/dashboard')
		])
	@endif

	<div class="wb-bg-grey content">
		<div class="container-fluid">
			<div id="wb-single-quote" class="wb-box">
				<div class="wb-cover-quote" style="position: relative;">
					@can('edit-job-quote', $jobQuote)
							<div class="div-block">
								@can('edit-job-quote', $jobQuote)
									@if ($jobQuote->status === 6)
										<a href="{{ url(sprintf('/dashboard/job-quotes/%s/edit', $jobQuote->id)) }}"
											class="btn wb-btn-primary pull-right mini2x pos-abs pos-top-right">
											Re-Submit
										</a>
									@else
										<a href="{{ url(sprintf('/dashboard/job-quotes/%s/withdraw', $jobQuote->id)) }}"
											class="btn wb-btn-primary pull-right mini2x pos-abs pos-top-right withdraw-quote" style="top: 25px;"
											data-toggle="modal"
											data-target="#withdraw-confirmation">
											Withdraw Quote
										</a>
										<a href="{{ url(sprintf('/dashboard/job-quotes/%s/edit', $jobQuote->id)) }}"
											class="btn wb-btn-primary pull-right mini2x pos-abs pos-top-right">
											Edit Quote
										</a>

										@include('modals.withdraw-modal', [
											'header' => 'Withdraw',
											'message' => 'Are you sure you want to withdraw your quote',
											'btnLabel1' => 'Yes, withdraw my quote!',
											'btnUrl1' => url(sprintf('/dashboard/job-quotes/%s/withdraw', $jobQuote->id)),
											'btnLabel2' => 'Oops, don\'t withdraw',
										])

									@endif
								@endcan
							</div>
					@endcan
					@include('partials.alert-messages')
					<div class="profile-img">
						@couple
							<a href="{{ url(sprintf('/vendors/%s', $jobQuote->user->vendorProfile->id)) }}"
								target="_blank">
									@if ($jobQuote->user->vendorProfile->profile_avatar)
									  <img src="{{ $jobQuote->user->vendorProfile->profile_avatar }}" alt="no image">
									@else
									  <img src="http://via.placeholder.com/180x130" alt="no image">
									@endif
							</a>
						@endcouple
						@vendor
							@php
								$coupleUser = $jobQuote->jobPost->user
							@endphp
							@if ($coupleUser && $coupleUser->coupleProfile()->profile_avatar)
							  <img src="{{ $coupleUser->coupleProfile()->profile_avatar }}" alt="no image">
							@else
							  <img src="{{ asset('/assets/images/couple-placeholder.jpg') }}" alt="no image">
							@endif
						@endvendor
					</div>
					@couple
						<a style="display: block; color: #353554;"
							target="_blank"
							href="{{ url(sprintf('/vendors/%s', $jobQuote->user->vendorProfile->id)) }}"
							class="name" style="color: #000;">
							<span style="font-size:28px;">{{ $jobQuote->user->vendorProfile->business_name }}</span>
						</a>
						<a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s', $jobQuote->user_id)) }}"
							class="btn wb-btn-primary"
							style="margin-top: 20px;">

							MESSAGE SUPPLIER
						</a>
					@endcouple
					@vendor
						<a style="display: block; color: #353554;"
							href="#"
							class="name" style="color: #000;">
							<span style="font-size:28px;">{{ $coupleUser->coupleProfile()->title }}</span>
						</a>
						<a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s', $jobQuote->jobPost->user_id)) }}"
							class="btn wb-btn-primary"
							style="margin-top: 20px;">
							MESSAGE COUPLE
						</a>
					@endvendor
				</div>
				<div class="wb-wrapper">
					<div class="row">
						<div class="col-lg-7 col-xl-8">
							<div class="details-block">
								<div class="message-block">
									<div class="sub-header" style="margin: 0 0 20px;">
										{{ $jobQuote->jobPost->userProfile->title }} |
										{{ $jobQuote->jobPost->category->name }} |
										{!! $jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}
									</div>
								</div>
								<ul class="list-unstyled">
									<li>
										<span class="icon"><i class="fa fa-calendar"></i></span>
										<label>Date Required: </label> {{ $jobQuote->jobPost->event_date }}
									</li>
									<li>
										<span class="icon"><i class="fa fa-star"></i></span>
										<label>Event Type: </label> {{ $jobQuote->jobPost->event->name }}
									</li>
									<li>
										<span class="icon"><i class="fa fa-users"></i></span>
										<label>Approx number of guests: </label>
										{{ $jobQuote->jobPost->number_of_guests }}
									</li>
									<li>
										<span class="icon"><i class="fa fa-map-marker"></i></span>
										<label>Venue or Address: </label>
										{{ $jobQuote->jobPost->required_address }}
									</li>
									<li>
										<span class="icon"><i class="fa fa-usd"></i></span>
										<label>Max Budget: </label> {{ $jobQuote->jobPost->budget }}
									</li>
									<li>
										<span class="icon"><i class="fa fa-clock-o"></i></span>
										<label>Time Required: </label>
										<span class="value">
											{{ $jobQuote->jobPost->timeRequirement ? $jobQuote->jobPost->timeRequirement->name : ''  }}
										</span>
									</li>
								</ul>
							</div>
							@include('partials.job-quotes.quote-details')
						</div>
						<div class="col-lg-5 col-xl-4">
							@if ($jobQuote->status === 1)
								@vendor
									<label class="wb-btn-orange-block" style="text-align: center;">
										Awaiting couple’s response
									</label>
								@endvendor
								@couple
									@include('partials.job-quotes.quote-response')
								@endcouple
							@elseif ($jobQuote->status === 2)
								@vendor
									<label class="wb-btn-orange-block" style="text-align: center;">
										Couple requested changes
									</label>
								@endvendor
								@couple
									<label class="wb-btn-orange-block" style="text-align: center;">
										You've requested changes
									</label>
								@endcouple
							@elseif ($jobQuote->status === 3)
								@couple
									@if (in_array($jobQuote->invoice->status, [0, 1]))
										<a href="{{ url(sprintf('payments/create?invoice_id=%s', $jobQuote->invoice->id)) }}"
											class="wb-btn-orange-block" style="text-align: center;">
											VIEW & PAY INVOICE
										</a>
									@else
										<label class="wb-btn-orange-block" style="text-align: center;">
											Fully Paid
										</label>
									@endif
								@endcouple
								@vendor
									@if ($jobQuote->invoice->status === 0)
										<label class="wb-btn-orange-block" style="text-align: center;">
											Invoice sent, awaiting payment
										</label>
									@elseif ($jobQuote->invoice->status === 1)
										<label class="wb-btn-orange-block" style="text-align: center;">
											Deposit Paid
										</label>
									@else
										<label class="wb-btn-orange-block" style="text-align: center;">
											Fully Paid
										</label>
									@endif
								@endvendor
							@elseif ($jobQuote->status === 4)
								<label class="wb-btn-orange-block" style="text-align: center;">
									@vendor
										Your quote was declined.
									@endvendor
									@couple
										You declined this quote.
									@endcouple
								</label>
							@elseif ($jobQuote->status === 5)
								<label class="wb-btn-orange-block" style="text-align: center;">
									Expired Quote
								</label>
								
								@if (auth()->user()->account == 'vendor')
								<p class="text-center" style="color: #FE5945;">YOU CAN EDIT THIS QUOTE TO EXTEND THE EXPIRY DATE & GIVE THE COUPLE MORE TIME</p>
								@else
								<p class="text-center" style="color: #FE5945;">YOU CAN MESSAGE THE BUSINESS TO REQUEST AN EXTENSION OF THIS QUOTE</p>
								@endif
							@elseif ($jobQuote->status === 6)
								<label class="wb-btn-orange-block" style="text-align: center;">
									This quote was withdrawn
								</label>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<form action="" id="withdraw-form" method="POST">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="patch">
		</form>
	</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/masonry/imagesloaded.pkgd.js') }}"></script>
<script src="{{ asset('assets/js/masonry/packery.pkgd.min.js') }}"></script>
<script>
	$('#image-wrapper').imagesLoaded().done(function(){
		window.$grid = $('#image-wrapper').packery();
	})
	$('.btn-withdraw').on('click', function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		var form = $('#withdraw-form');
		form.attr('action', link);
		form.submit();
	});
</script>
@endpush
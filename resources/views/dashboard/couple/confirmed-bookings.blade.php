@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	{{-- @include('partials.job-posts.search-form', [
		'action' => url('dashboard/confirmed-bookings'),
		'hideLocationSearch' => true
	]) --}}
	@if(session()->has('modal_message'))
		@include('modals.success-modal', [
			'header' => 'REFUND REQUEST',
			'message' => session('modal_message'),
		])
	@endif
	@if(session()->has('success_review'))
		@include('modals.success-modal', [
			'header' => '',
			'message' => session('success_review'),
		])
	@endif
	@include('modals.request-refund-for-couple')
	@if (count($confirmedBookings) > 0)
	<br />
			@php
				$i = 0;
			@endphp
			@foreach($confirmedBookings as $booking)
				@if ( ( $i % 2 ) == 0)
					<div class="row">
				@endif
				<div class="col-sm-12 col-md-12 col-lg-6">
					<div class="box wb-booked-box">
						<div class="box-header with-border">
							<h3 class="box-title">
								<span class="title">
									<a href="{{ url(sprintf('/vendors/%s', $booking->jobQuote->user->vendorProfile->id)) }}">
									   {{ $booking->jobQuote->user->vendorProfile->business_name }}
									</a>
								</span>
								<span class="pull-right dropdown d-inline" style="display: inline; vertical-align: middle; ">
									<a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left: 0px;"><i class="fa fa-ellipsis-v"></i>
									</a>
									<span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a style="padding: 0 10px; display: inline-block; width: 100%;" class="dropdown-item request-refund"
											data-invoiceid="{{ $booking->id }}"
											href="#" data-toggle="modal"
											data-target="#modal-request-refund">CANCEL BOOKING / REQUEST REFUND</a>
									</span>
								</span>
							</h3>
							<div class="confbuts">
								<span class="msg-couple" style="margin-right: 5px;">
									@if ($booking->jobQuote->vendor_review_status === 0)
										<a href="#" data-toggle="modal"
											data-jobquoteid="{{ $booking->jobQuote->id }}"
											data-target="#submit-review"
											class="btn wb-btn-primary mini2x submit-review">
											Review this Business
										</a>
									@endif
								</span>
								<span class="right book-details" style="margin-right: 5px;">
									<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $booking->jobQuote->id))}}"
										class="btn wb-btn-primary mini2x">
											BOOKING DETAILS
									</a>
								</span>
								<span class="right msg-couple">
									<a href="{{ url(sprintf('dashboard/messages?recipient_user_id=%s', $booking->jobQuote->user->id)) }}" class="btn wb-btn-primary mini2x">
										MESSAGE VENDOR
									</a>
								</span>
							</div>
						</div>
						<div class="box-body book-jobs">
							<div class="job-thumbnail">
								<img src="{{ $booking->jobQuote->user->vendorProfile->profile_avatar ?? 'http://via.placeholder.com/140x120'}}" class="img-responsive" alt="">
							</div>
							<div class="job-content">
								<div class="row-no-padding">
									<div class="col-md-4">
										<div class="title">EVENT</div>
										<p class="subtitle m-b-none">{{ $booking->jobQuote->jobPost->event->name }}</p>
									</div>
										<div class="col-md-4">
											<div class="title ">CATEGORY</div>
											<p class="subtitle m-b-none">{{ $booking->jobQuote->jobPost->category->name }}</p>
										</div>
										<div class="col-md-4">
											<div class="title">EVENT DATE</div>
											<p class="subtitle m-b-none">{{ $booking->jobQuote->jobPost->event_date }}</p>
										</div>
										<div class="col-xs-12">
											<div class="title">LOCATION</div>
											<p class="subtitle">{!! $booking->jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}</p>
										</div>
										<div class="col-md-4">
											<div class="title">NEXT PAYMENT DUE</div>
											<p class="subtitle m-b-none">{{ $booking->next_payment_date }}</p>
										</div>
										<div class="col-md-4"><div class="title">TOTAL INVOICE</div>
										<p class="subtitle m-b-none">$ {{ number_format($booking->total, 2, '.', ',') }}</p>
									</div>
									<div class="col-xs-4">
										@if ($booking->balance > 0)
											<div class="title">
												<a href="{{ url(sprintf('/payments/create?invoice_id=%s', $booking->id)) }}">
													OUTSTANDING AMOUNT
												</a>
											</div>
											<p class="subtitle m-b-none">
												<a href="{{ url(sprintf('/payments/create?invoice_id=%s', $booking->id)) }}">
													$
													<span class="text-danger">
														{{ number_format($booking->balance, 2, '.', ',') }}
													</span>
												</a>
											</p>
										@else
											<div class="title">OUTSTANDING AMOUNT</div>
												<p class="subtitle m-b-none">
												$
												<span class="text-danger">
													{{ number_format($booking->balance, 2, '.', ',') }}
												</span>
											</p>
										@endif
									</div>
								</div>
							</div>
						</div>

						@if($booking->is_cancelled)
							<div class="overlay-cancelled">
								<h1>BOOKING<br>CANCELLED</h1>
							</div>
						@endif
					</div>
				</div>
				@php
					$i++;
				@endphp
				@if ( ( $i % 2 ) == 0 )
					</div><!-- /.row -->
				@endif
			@endforeach
			<div class="pagination-wrap">
				{{ $confirmedBookings->appends(request()->all())->links() }}
			</div>

	@else
		<h3 class="text-center">
			No confirmed bookings found.
		</h3><!-- /.text-center -->
	@endif
	</section>
	@include('modals.vendor-review')
@endsection
@push('scripts')
	<script type="text/javascript">
		$('.request-refund').on('click', function(e){
			var invoiceId = $(this).attr('data-invoiceid');
			$('#request-refund').attr('action', '/dashboard/refund/' + invoiceId);
		});
	</script>
@endpush
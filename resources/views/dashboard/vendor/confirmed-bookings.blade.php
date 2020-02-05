@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	@include('partials.job-posts.search-form', [
		'action' => url('dashboard/confirmed-bookings'),
		'hideLocationSearch' => true
	])
	@if(session()->has('modal_message'))
		@include('modals.success-modal', [
			'header' => 'REFUND REQUEST',
			'message' => session('modal_message'),
		])
	@endif
	@include('modals.request-refund-for-vendor')
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
						@php
							if ($booking->jobQuote->jobPost->user->coupleA) {
								$userId = $booking->jobQuote->jobPost->user->coupleA->userA_id;
								$coupleTitle = $booking->jobQuote->jobPost->user->coupleA->title;
								$avatar = $booking->jobQuote->jobPost->user->coupleA->profile_avatar;

							} else {
								$userId = $booking->jobQuote->jobPost->user->coupleB->userB_id;
								$coupleTitle = $booking->jobQuote->jobPost->user->coupleB->title;
								$avatar = $booking->jobQuote->jobPost->user->coupleB->profile_avatar;
							}
						@endphp
						<div class="box-header with-border">
							<h3 class="box-title">
								<span class="title">
									{{ $coupleTitle }}
								</span>
								<span class="right msg-couple">
									<a href="{{ url(sprintf('dashboard/messages?recipient_user_id=%s', $userId)) }}" class="btn wb-btn-primary mini2x">
										MESSAGE COUPLE
									</a>

									<span class="dropdown d-inline" style="display: inline; vertical-align: middle; ">
										<a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left: 0px;"><i class="fa fa-ellipsis-v"></i>
										</a>
										<span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a style="padding: 0px 10px; display: inline-block; width: 100%;" class="dropdown-item request-refund"
												data-invoiceid="{{ $booking->id }}"
												href="#" data-toggle="modal"
												data-target="#modal-request-refund">CANCEL BOOKING / ISSUE REFUND</a>
										</span>
									</span>
								</span>
								<span class="right book-details">
									<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $booking->jobQuote->id))}}"
										class="btn wb-btn-primary mini2x">
											BOOKING DETAILS
									</a>&nbsp;&nbsp;&nbsp;&nbsp;
								</span>
							</h3>
						</div>

						<div class="box-body book-jobs">
							<div class="job-thumbnail">
								<img src="{{ $avatar ?? asset('/assets/images/couple-placeholder.jpg') }}" class="img-responsive" alt="">
							</div>
							<div class="job-content">
								<div class="row-no-padding">
									<div class="col-xs-12 col-sm-4">
										<div class="title">EVENT</div>
										<p class="subtitle m-b-none">{{ $booking->jobQuote->jobPost->event->name }}</p>
									</div>
										<div class="col-xs-12 col-sm-4 text-right">
											<div class="title ">CATEGORY</div>
											<p class="subtitle m-b-none">{{ $booking->jobQuote->jobPost->category->name }}</p>
										</div>
										<div class="col-xs-12 col-sm-4 text-right">
											<div class="title">EVENT DATE</div>
											<p class="subtitle m-b-none">{{ $booking->jobQuote->jobPost->event_date }}</p>
										</div>
										<div class="col-xs-12">
											<div class="title">LOCATION</div>
											<p class="subtitle">{!! $booking->jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}</p>
										</div>
										<div class="col-xs-12 col-sm-4">
											<div class="title">NEXT PAYMENT DUE</div>
											<p class="subtitle m-b-none">{{ $booking->next_payment_date }}</p>
										</div>
										<div class="col-xs-12 col-sm-4 text-right"><div class="title">TOTAL INVOICE</div>
										<p class="subtitle m-b-none">
											$ {{ number_format($booking->total, 2, '.', ',') }}
										</p>
									</div>
									<div class="col-xs-12 col-sm-4 text-right">
										<div class="title">
											<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $booking->jobQuote->id)) }}">
												OUTSTANDING AMOUNT
											</a>
										</div>
										<p class="subtitle m-b-none text-right">
											<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $booking->jobQuote->id)) }}">
												$
												<span class="text-danger">
													{{ number_format($booking->balance, 2, '.', ',') }}
												</span>
											</a>
										</p>
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
@endsection

@push('scripts')
	<script type="text/javascript">
		$('.request-refund').on('click', function(e){
			var invoiceId = $(this).attr('data-invoiceid');
			$('#request-refund').attr('action', '/dashboard/refund/' + invoiceId);
		})
	</script>
@endpush
@extends('layouts.secured')

@section('content')
	@if (config('app.env') === 'production')
		<script src="https://js.promisepay.com/PromisePay.js" type="text/javascript"></script>
	@else
		<script src="https://js.prelive.promisepay.com/PromisePay.js" type="text/javascript"></script>
	@endif
    <style>
        .primary-assets-not-loaded,
        .secondary-assets-not-loaded {
            display: none!important;
		}
		
		input.form-control, select.form-control {
			border: 1px solid #ccd0d2;
		}

		#wedbooker-credit-card-payment-form input[type=radio]:checked + label:before, #wedbooker-credit-card-payment-form input[type=radio] + label:before {
			content: none;
		}

		.response-block .wb-tab-accept .nav-tabs li a, .response-block .wb-tab-accept .nav-tabs li.active a {
			margin: 0;
			border: 0;
		}

		.cc-selector input{
			margin:0;padding:0;
			-webkit-appearance:none;
			-moz-appearance:none;
					appearance:none;
		}

		.visa{background-image:url(http://i.imgur.com/lXzJ1eB.png);}
		.mastercard{background-image:url(http://i.imgur.com/SJbRQF7.png);}

		.cc-selector input:active +.drinkcard-cc{opacity: .5;}
		.drinkcard-cc{
			cursor:pointer;
			background-size:contain;
			background-repeat:no-repeat;
			display:inline-block;
			width: 50px;
			height: 30px;
			margin: 5px;
		}
		.cc-selector .notSelected {
			-webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
			-moz-filter: brightness(1.8) grayscale(1) opacity(.7);
					filter: brightness(1.8) grayscale(1) opacity(.7);
		}

		.drinkcard-cc:hover{
			-webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
			-moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
					filter: brightness(1.2) grayscale(.5) opacity(.9);
		}
    </style>
	<div class="wb-bg-grey">
		<div class="container">
            <h4 id="loading-assets-notification" class="text-center">
                Loading page... please wait. If this takes too long, please make sure your browser is updated to avoid any issues.
            </h4>
			<div id="wb-single-quote" class="wb-box primary-assets-not-loaded secondary-assets-not-loaded">
				<div class="wb-cover-quote">
					<div class="profile-img">
						@if ($invoice->vendor->profile_avatar)
						<img src="{{ $invoice->vendor->profile_avatar }}" alt="no image">
						@else
						<img src="http://via.placeholder.com/180x130" alt="no image">
						@endif
					</div>
					<a style="display: block; color: #353554;"
						href="{{ url(sprintf('/vendors/%s', $invoice->vendor->id)) }}"
						class="name" style="color: #000;">
						<span style="font-size:28px;">{{ $invoice->vendor->business_name }}</span>
					</a>
					@couple
					<a href="{{ url(sprintf('dashboard/messages?recipient_user_id=%s', $invoice->user_id)) }}"
						class="btn wb-btn-primary"
						style="margin-top: 20px;">
						MESSAGE SUPPLIER
					</a>
					@endcouple
				</div>
				<div class="wb-wrapper">
					<div class="row">
						<div class="col-md-7">
							@include('partials.payments.invoice-details')
						</div>
						<div class="col-md-5">
							{{-- <a href="{{ url(sprintf('/invoice/%s/pdf', request('invoice_id'))) }}"
								target="_blank"
								class="btn btn-block wb-btn-ivory btn-border-primary"
								style="text-align: center;">
								Download a copy of the invoice
							</a>
							<br/> --}}
							<div class="response-block">
								<div class="wb-tab-accept">
									<ul class="nav nav-tabs nav-justified">
										<li class="active">
											<a href="#credit-card" data-toggle="tab" aria-expanded="false" class="{{-- tab-coral --}}">
												Pay by Credit Card
											</a>
										</li>
										<!-- <li class="">
											<a href="#direct-debit" data-toggle="tab" aria-expanded="false" class="{{-- tab-coral --}}">
												Direct Debit
											</a>
										</li> -->
									</ul>
									<div class="tab-content paymethod">
										<div class="tab-pane active" id="credit-card">
											@include('partials.payments.credit-card-form')
										</div>
										<!-- <div class="tab-pane" id="direct-debit">
											@include('partials.payments.direct-debit-form')
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="success-confirmation" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
		<div id="wb-modal-success" class="modal-dialog">
			<div class="modal-dialog">
                <div class="logo-container">
                    <div class="logo">
                        <span><i class="fa fa-check"></i></span>
                    </div>
                </div>
				<div class="modal-content text-center">
					<div class="modal-header">
						PAYMENT CONFIRMATION
					</div>

					<div class="modal-body ">
						<p>
							{{ sprintf('You have made payment to %s for your %s booking.', $invoice->vendor->business_name, $invoice->jobQuote->jobPost->category->name) }}
						</p>
					</div>
					<div class="modal-footer">
						<a href="{{ url('/dashboard') }}" type="button" class="btn wb-btn wb-btn-outline-danger">MY DASHBOARD</a>
						<a href="{{ url('/dashboard/invoices-and-payments') }}" type="button" class="btn wb-btn wb-btn-outline-danger">
							Invoices and Payments
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('assets/js/masonry/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ asset('assets/js/masonry/packery.pkgd.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#wb-single-quote').removeClass('secondary-assets-not-loaded');
			$(':radio').on('change', function () {
				$(this).next('.drinkcard-cc').removeClass('notSelected');
				$(':radio').not($(this)).next('.drinkcard-cc').addClass('notSelected');
			});
        })
        $('#image-wrapper').imagesLoaded().done(function(){
            window.$grid = $('#image-wrapper').packery();
        })
    </script>
@endpush
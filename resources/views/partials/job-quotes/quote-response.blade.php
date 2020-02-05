@push('css')
<style>
	.tooltip-holder.tool-info {
		position: unset;
		text-align: center;
		border-right: 1px solid #DBDBDB;
		border-top: 1px solid #DBDBDB;
	}
	.tooltip-holder.tool-info .tooltip-alt {
		padding: 10px;
		width: 100%;
		right: 0;
	}

	@media only screen and (max-width: 886px) {
		.tooltip-holder.tool-info {
			display: block!important;
			margin: auto;
			width: 100%!important;
			border-left: 1px solid #DBDBDB;
			border-top: 0;
			background: #FCFBF7;
		}
	}
</style>
@endpush

<div class="response-block">
	<div class="wb-tab-accept">
		{{-- <ul class="nav nav-tabs nav-justified">
			<li class="active">
				<a href="#accept_tab" data-toggle="tab" aria-expanded="false">ACCEPT<br/>QUOTE</a>
			</li>
			<li class="">
				<a href="#request_tab" data-toggle="tab" aria-expanded="false">REQUEST<br/>CHANGES</a>
			</li>
			<li class="">
				<a href="#decline_tab" data-toggle="tab" aria-expanded="true">DECLINE<br/>QUOTE</a>
			</li>
			<li class="tooltip-holder tool-info">
				<i class="fa fa-info-circle"></i>
				<div class="tooltip-alt">
					You can discuss this quote with the business and request any changes you'd like using the "Request changes" option below. Once you are happy with the quote, you can use the "Accept" button to proceed with confirming your booking.
				</div>
			</li>
		</ul> --}}

		<a href="#accept_tab" class="hide accept_tab" data-toggle="tab" aria-expanded="false">a</a>
		<a href="#request_tab" class="hide request_tab" data-toggle="tab" aria-expanded="false">REQUEST<br/>CHANGES</a>
		<a href="#decline_tab" class="hide decline_tab" data-toggle="tab" aria-expanded="true">DECLINE<br/>QUOTE</a>

		<div class="tab-content quote-res">
			<h3 class="wb-title-quote">Would You Like To Book {{ $jobQuote->user->vendorProfile->business_name }}?</h3>
			<select class="form-control select-quote">
				<option value="accept_tab">Yes, accept quote</option>
				<option value="decline_tab">No, decline quote</option>
				<option value="request_tab">Maybe, request changes to quote</option>
			</select>
			<div class="tab-pane active" id="accept_tab">
				<div class="">
					<form class="form" action="{{ url(sprintf('/job-quotes/%s/response', $jobQuote->id)) }}" method="post">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="PATCH">
						<textarea name="message" rows="6" placeholder="Option to include a message to the business"></textarea>
						<div class="action-buttons" style="inline">
							<button type="submit" name="job_quote_response" value="accepted" class="btn wb-btn-orange-block">
								ACCEPT QUOTE
							</button>
						</div>
					</form>
				</div>
			</div>
			<div class="tab-pane" id="request_tab">
				<div class="">
					<form class="form" action="{{ url(sprintf('/job-quotes/%s/response', $jobQuote->id)) }}" method="post">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="PATCH">
						<textarea name="message" rows="6" placeholder="Option to include a message to the business"></textarea>
						<div class="action-buttons" style="inline">
							<button type="submit" name="job_quote_response" value="request changes" class="btn wb-btn-orange-block">
								REQUEST CHANGES TO QUOTE
							</button>
						</div>
					</form>
				</div>
			</div>
			<div class="tab-pane" id="decline_tab">
				<div class="">
					<form class="form" action="{{ url(sprintf('/job-quotes/%s/response', $jobQuote->id)) }}" method="post">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="PATCH">
						<textarea name="message" rows="6" placeholder="Option to include a message to the business"></textarea>
						<div class="action-buttons" style="inline">
							<button type="submit" name="job_quote_response" value="declined" class="btn wb-btn-orange-block">
								DECLINE QUOTE
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
	$('.select-quote').change(function() {
		let tab = $(this).val();
		$('.' + tab).click();
	})
</script>
@endpush
@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding, Contact Us"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "Get in touch with a member of the wedBooker team today"}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "Get in touch with wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-get-in-touch" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'Contact Us' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Jimmy Raper' }}</div><!-- /.caption -->
</div>
<section id="wb-get-in-touch" class="wb-bg-grey">
	<div class="container">
		<div class="row" style="margin-bottom: 100px;">
			<div class="col-md-8 col-md-offset-2">
				<div class="form-content" style="box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 4px; padding: 35px 30px;">
					<form action="{{ url('contact-us/send') }}" method="post" id="contact-us-form">
						{{ csrf_field() }}
						@include('partials.alert-messages')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Name <span class="required">*</span></label>
									<input type="text" name="name" value="{{ old('name') }}" required="required" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Email <span class="required">*</span></label>
									<input type="text" name="email" value="{{ old('email') }}" required="required" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Phone (Optional)</label>
									<input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">How did you hear about us (Optional)</label>
									<select name="source" class="contact-select form-control" required>
										<option value="Facebook">Facebook</option>
										<option value="Instagram">Instagram</option>
										<option value="Pinterest">Pinterest</option>
										<option value="LinkedIn">LinkedIn</option>
										<option value="Google">Google</option>
										<option value="Bing">Bing</option>
										<option value="Word of Mouth">Word of Mouth</option>
										<option value="Magazine or Newspaper">Magazine or Newspaper</option>
										<option value="Other">Other</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="">Reason For Contacting Us <span class="required">*</span></label>
									<select name="reason" class="contact-select form-control" required>
										{{-- <option value="I'd like to pre-register as a couple">I'd like to pre-register as a couple</option> --}}
										<option value="General Enquiry">General Enquiry</option>
										<option value="Supplier or Venue Enquiry">Supplier or Venue Enquiry</option>
										<option value="Wedding Couple Enquiry">Wedding Couple Enquiry</option>
										<option value="Payment Enquiry">Payment Enquiry</option>
										<option value="Submit Feedback">Submit Feedback</option>
										<option value="Submit A Real Wedding For Our Blog">Submit A Real Wedding For Our Blog</option>
										<option value="Unsubscribe me please">Unsubscribe me please</option>
									</select>
								</div>

							</div>
						</div>
						<div class="form-group">
							<label for="">Message <span class="required">*</span></label>
							<textarea name="message" rows="4" cols="80" required="required" class="form-control">{{ old('message') }}</textarea>
						</div>
						<div class="checkbox">
							<div class="checkbox">
								<input id="subscribe" name="subscribe" type="checkbox" checked>
								<label for="subscribe">Subscribe to the wedBooker newsletter for updates on new wedBooker Venues and Suppliers as well as a bunch of wedding planning tips and tools.</label>
							</div>
						</div>

						<div class="checkbox">
						 <div class="checkbox">
							<input id="ppolicy" name="ppolicy" type="checkbox" checked>
							<label for="subsppolicy cribe">I understand that the information collected in this form is collected in accordance with the wedBooker <a href="{{ url('/privacy-policy') }} " target="_blank"><u>Privacy Policy.</u></a> </label>
						</div>
					</div>
					<div class="row">
					 <div class="col-md-6">
						<div class="form-group">
						   <label for="">Prove you are not a robot: <strong id="question"></strong></label>
						   <input type="text" id="user-answer" class="form-control">
					   </div>
				   </div>
			   </div>
			   <div class="form-group">
				 <button id="send-message" class="btn btn-danger">SEND MESSAGE</button>
			 </div>
		 </form>
	 </div>
 </div>
</div>
</div>
</section>
@if(session()->has('success'))
@include('modals.success-contact-modal')
@endif
@endsection
@push('scripts')
<script>
	var num1 = getRandomInt(20);
	var num2 = getRandomInt(20);
	var answer = parseInt(num1) + parseInt(num2);

	$('#question').html(num1 +' + '+ num2);

	function getRandomInt(max) {
		return Math.floor(Math.random() * Math.floor(max));
	}

	$('#send-message').on('click', function(e){
		e.preventDefault();
		var userAnswer = parseInt($('#user-answer').val());

		if (!userAnswer) {
			alert('Prove you are not a robot!');
			return false;
		}

		if (userAnswer != answer) {
			alert('Incorrect answer!');
			return false;
		}

		$('#contact-us-form').submit();
	})
</script>
@endpush

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection
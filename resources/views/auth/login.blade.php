@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding, login"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "Login to your wedBooker account"}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wb-sign-in" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'Welcome to wedBooker' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Jenna Fahey-White' }}</div><!-- /.caption -->
</div>
<section  class="login-register">
	<div class="container">
		@include('partials.auth.actions')
		@include('partials.auth.login-form')
	</div>
</section>
@endsection
@push('scripts')
<script type="text/javascript">
	$('.login-register .wb-form-group').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		$('label span', this).hide();
		$('label', this).addClass('active');
		$('input', this).focus();
	});

	$('.login-register .wb-form-group input').on('focus', function(event) {
		event.preventDefault();
		/* Act on the event */
		labelSpan = $(this).closest('.wb-form-group').find('label span');
		label = $(this).closest('.wb-form-group').find('label');
		labelSpan.hide();
		label.addClass('active');
	});

	$('.login-register .wb-form-group input').on('blur', function(event) {
		var inputValue = $(this).val();
		if ( inputValue == '' ) {

			labelSpan = $(this).closest('.wb-form-group').find('label span');
			label = $(this).closest('.wb-form-group').find('label');
			labelSpan.show();
			label.removeClass('active');

		}
	});
	$('input[type="email"]').focus();
</script>
@endpush

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection
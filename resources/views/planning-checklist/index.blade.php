@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker helps Couples to efficiently book talented Suppliers and beautiful Venues around Australia. The first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place."}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "Planning Checklist"}}">
@endsection

@push('css')
<style type="text/css">
</style>
@endpush

@section('content')
<div class="wb-small-banner" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'Planning Checklist' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Andreas Holm' }}</div><!-- /.caption -->
</div>

<section id="wb-planning-checklist">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-4 wb-content">
				<div class="item image-checklist">
					<img src="{{ ($result = $pageSettings->firstWhere('meta_key', "checklist_img")) ? Storage::url($result->meta_value) : asset('assets/images/checklist.jpg') }}" class="wb-icon" />
					<div class="overlay-checklist">
						<div class="text-checklist">
							<p>{!! $pageSettings->firstWhere('meta_key', "checklist_hover_text")['meta_value'] ? strip_tags($pageSettings->firstWhere('meta_key', "checklist_hover_text")['meta_value']) : 'Subscribe below to download your free copy' !!}</p>
							<img src="{{ asset('assets/images/arrow-checklist-white.png') }}" class="arrow-checklist" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 wb-content">
				<div class="item">
					<p class="wb-lead">{!! $pageSettings->firstWhere('meta_key', "checklist_title")['meta_value'] ? strip_tags($pageSettings->firstWhere('meta_key', "checklist_title")['meta_value']) : 'Download Your Free Wedding Checklist' !!}</p>
					<p class="wb-details">{!! $pageSettings->firstWhere('meta_key', "checklist_text")['meta_value'] ? strip_tags($pageSettings->firstWhere('meta_key', "checklist_text")['meta_value']) : 'Let us guess. Now you\'re wondering how to plan your wedding? Don\'t worry you\'re not alone. Lucky for you, wedBooker has created our very own Wedding Checklist, for the ultimate guide in how to plan your wedding. Simply subscribe to our email newsletter to receive free wedding tips, exclusive offers, and download your free wedding checklist today.' !!}</p>
					<img src="{{ asset('assets/images/arrow-checklist.png') }}" class="arrow-checklist" />
				</div>
			</div>
		</div>
	</div>
</section>

<section class="wb-block danger-bg subscribe-form">
	<div class="row d-flex">
		<div class="col-md-7 col-sm-7 col-xs-12">
			<h1 class="text">{!! $pageSettings->firstWhere('meta_key', 'subscribe_text')->meta_value ?? 'Subscribe to download your free wedding checklist' !!}</h1>
			<form class="form-inline" id="subscribe-download">
				<div class="form-group mb-2">
					<input type="text" class="form-control" id="mc-fname" name="fname" placeholder="First Name">
				</div>
				<div class="form-group mb-2">
					<input type="text" class="form-control" id="mc-lname" name="lname" placeholder="Last Name">
				</div>
				<div class="form-group mx-sm-3 mb-2">
					<input type="email" class="form-control" id="mc-email" name="email" placeholder="Email Address">
				</div>
				<button type="submit" id="subscribe-checklist" class="btn btn-danger">{!! $pageSettings->firstWhere('meta_key', 'subscribe_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'subscribe_button')->meta_value) : 'Get Free Checklist' !!}</button>
			</form>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-12">
			<img src="{{ ($result = $pageSettings->firstWhere('meta_key', 'subscribe_img')) ? Storage::url($result->meta_value) : asset('assets/images/subscribe.png') }}" class="img-responsive coral-inner-img" alt="">
		</div>
	</div>
</section>

<div class="modal" tabindex="-1" role="dialog" id="subscription-response">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-body text-center">
		  <p class="text-primary response-text" style="margin: 0; font-weight: 300;">Mark all notifications as read?</p>
		</div>
		<div class="modal-footer" style="text-align: center;">
			<button type="button" class="btn wb-btn-orange" data-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
</div>

@endsection

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection

@push('scripts')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118656091-1"></script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', "<?php echo env('GOOGLE_ANALYTICS_TRACKING_ID'); ?>", 'auto');
	ga('require', 'WEDDING CHECKLISTS SUBS');
</script>

<script>
	function forceDownload(blob, filename) {
		var a = document.createElement('a');
		a.download = filename;
		a.href = blob;

		// For Firefox https://stackoverflow.com/a/32226068
		document.body.appendChild(a);
		a.click();
		a.remove();
	}

	// Current blob size limit is around 500MB for browsers
	function downloadResource(url, filename) {
		if (!filename) filename = url.split('\\').pop().split('/').pop();
		fetch(url, {
			headers: new Headers({
				'Origin': location.origin
			}),
			mode: 'cors'
		})
		.then(response => response.blob())
		.then(blob => {
			let blobUrl = window.URL.createObjectURL(blob);
			forceDownload(blobUrl, filename);
		})
		.catch(e => console.error(e));
	}

	$(document).ready((e)=> {
		$('#subscribe-download').submit(function(event) {
			event.preventDefault();

			var email = $('#mc-email').val(),
				fname = $('#mc-fname').val(),
				lname = $('#mc-lname').val();

			if(email == '' || fname == ''|| lname == '') {
				$('.response-text').text('Please insert your name and email address.');
				$('#subscription-response').modal('show');
				return false;
			}
			
			var data = {
				'email': email,
				'fname': fname,
				'lname': lname,
				'_token': csrf_token
			};

			// Send data to PHP script via .ajax() of jQuery
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '/planning-checklist',
				data: data,
				beforeSend: function() {
					NProgress.start();
				},
				success: function (response) {
					// if(response.message == 'Thank you for subscribing to our list.') {
						downloadResource(response.download, response.file_name);
					// }
					$('.response-text').text(response.message);
					$('#subscription-response').modal('show');
					NProgress.done();
				},
				error: function (response) {
					console.log(response);
					NProgress.done();
				}
			});
		});
	})
</script>
@endpush
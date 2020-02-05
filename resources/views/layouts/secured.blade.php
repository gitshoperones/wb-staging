<!DOCTYPE html>
<!-- secured header -->
<html lang="{{ app()->getLocale() }}">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118656091-1"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', "<?php echo env('GOOGLE_ANALYTICS_TRACKING_ID'); ?>", 'auto');
        ga('require', 'ecommerce');
    </script>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="wedBooker is an online market network helping Couples to efficiently book talented Suppliers and beautiful Venues around Australia. wedBooker is Australia’s first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place. wedBooker takes the stress out of weddings. Sign up for free today!"/>
	<title>{{ config('app.name', 'WedBooker') }}</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" />

	{{-- Default website image for social sharing --}}
	<meta property="og:image" content="{{ asset('/apple-touch-icon-200x200.png') }}">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="200">
	<meta property="og:image:height" content="200">
	<meta property="og:type" content="website" />
	<meta property="og:url" content="{{ url('/') }}" />
	<meta property="og:description" content="wedBooker is an online market network helping Couples to efficiently book talented Suppliers and beautiful Venues around Australia. wedBooker is Australia’s first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place. wedBooker takes the stress out of weddings. Sign up for free today!" />
	{{-- fav icons --}}
	<link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon" />
	<link rel="apple-touch-icon" href="{{ asset('/apple-touch-icon.png') }}" />
	<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/apple-touch-icon-57x57.png') }}" />
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/apple-touch-icon-72x72.png') }}" />
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/apple-touch-icon-76x76.png') }}" />
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/apple-touch-icon-114x114.png') }}" />
	<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/apple-touch-icon-120x120.png') }}" />
	<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/apple-touch-icon-144x144.png') }}" />
	<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/apple-touch-icon-152x152.png') }}" />
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon-180x180.png') }}" />
	{{-- end fav icons --}}

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

	@stack('styles')
</head>
<body>
	@if (config('app.env') === 'production')
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5SV3VKF"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	@endif
	<div id="app">
		<div class="body">
            @impersonating
                @include('partials.impersonating-alert')
            @endImpersonating
			@include('partials.header')
			@yield('content')
			@include('partials.about')
			@include('partials.bottom-social-icons')
			@include('partials.footer')
		</div>
	</div>
	
	<script>
        $(document).ready(function(){
			$('div.body').css('margin-top', $('.wb-header').outerHeight());
		});
	</script>

	@stack('scripts')
</body>
</html>

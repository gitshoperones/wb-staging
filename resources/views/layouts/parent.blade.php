<!DOCTYPE html>
<!-- dashboard header -->
<html>
<head>
	@if (config('app.env') === 'production')
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5SV3VKF');</script>
	<!-- End Google Tag Manager -->
	@endif
	<meta charset="UTF-8">
	<title>{{ ucfirst(Auth::user()->account) }} Dashboard</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="pusher-key" content="{{ env('PUSHER_APP_KEY') }}">
	<meta name="pusher-cluster" content="{{ env('PUSHER_APP_CLUSTER') }}">
	<meta name="description" content="wedBooker is an online market network helping Couples to efficiently book talented Suppliers and beautiful Venues around Australia. wedBooker is Australia’s first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place. wedBooker takes the stress out of weddings. Sign up for free today!"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/_all-skins.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" >

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
	@stack('css')
	@yield('css')
	<link href="{{ asset('assets/vendor/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
	<script type="text/javascript" src="{{ asset('assets/vendor/sweetalert/sweetalert2.all.min.js') }}"></script>
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<link href="{{ asset('assets/css/nprogress.css') }}" rel="stylesheet" />
	<script type="text/javascript" src="{{ asset('assets/js/nprogress.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
</head>
<body class="wb-frontend-dashboard sidebar-mini sidebar-collapse parent">
	@if (config('app.env') === 'production')
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5SV3VKF"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	@endif
	<div id="app">
		<div class="wrapper">
			<!-- Main Header -->
			@include('partials.dashboard.header')
			<!-- Content Wrapper. Contains page content -->
			@impersonating
				@include('partials.impersonating-alert')
			@endImpersonating
			@yield('content')
			<!-- Main Footer -->
			@include('partials.dashboard.footer')
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
	<!-- AdminLTE App -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.js"></script>
	<script type="text/javascript" src="{{ asset('assets/js/stupidtable.min.js') }}"></script>
	<script src="{{ asset('/js/app.js') }}"></script>
	<script>
		NProgress.configure({ showSpinner: true });
		NProgress.start();

		$(document).ready(function(){
			NProgress.done();
		})

		$.fn.datepicker.defaults.autoclose = true;
		
		$('.disable-onclick').click(function() {
			$(this).addClass('disabled')
		});
	</script>
	@yield('scripts')
	@stack('scripts')
</body>
</html>

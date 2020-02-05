@php
$requestPath = Request::path();
$menuItems = [
	[
		'path' => 'dashboard',
		'icon_active' => asset('assets/images/icons/dashboard/home2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/home.png'),
		'name' => 'Home',
	],
	[
		'path' => 'dashboard/job-posts/create',
		'icon_active' => asset('assets/images/icons/dashboard/post_job2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/post_job.png'),
		'name' => 'Post A New Job',
	],
	[
		'path' => 'suppliers-and-venues',
		'icon_active' => asset('assets/images/icons/dashboard/browse_sup2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/browse_sup.png'),
		'name' => 'Browse Suppliers',
	],
	[
		'path' => 'dashboard/job-posts/live',
		'icon_active' => asset('assets/images/icons/dashboard/our_job_listings2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/our_job_listings.png'),
		'name' => 'Our Live Jobs',
	],
	[
		'path' => 'dashboard/received-quotes',
		'icon_active' => asset('assets/images/icons/dashboard/sent_quotes2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/sent_quotes.png'),
		'name' => 'Quotes Received',
	],
	[
		'path' => 'dashboard/job-posts/draft',
		'icon_active' => asset('assets/images/icons/dashboard/draft2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/draft.png'),
		'name' => 'Draft Jobs',
	],
	[
		'path' => 'dashboard/confirmed-bookings',
		'icon_active' => asset('assets/images/icons/dashboard/our_bookings2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/our_bookings.png'),
		'name' => 'Confirmed Bookings',
	],
	// [
	// 	'path' => 'dashboard/todo-list',
	// 	'icon_active' => asset('assets/images/icons/dashboard/todo2.png'),
	// 	'icon_inactive' => asset('assets/images/icons/dashboard/todo.png'),
	// 	'name' => 'To Do List',
	// ],
	[
		'path' => 'dashboard/invoices-and-payments',
		'icon_active' => asset('assets/images/icons/dashboard/payments2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/payments.png'),
		'name' => 'Invoices & Payments',
	],
	[
		'path' => 'dashboard/favorite-vendors',
		'icon_active' => asset('assets/images/icons/dashboard/favourites2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/favourites.png'),
		'name' => 'Our Favourites',
	],
];
@endphp

<aside class="main-sidebar" id="sidebar-wrapper">
	<section class="sidebar">
		<ul class="sidebar-menu">
			@foreach($menuItems as $item)
				@if ($item['path'] === $requestPath)
					<li class="active">
						<a href="{{ url('/'.$item['path']) }}">
							<img src="{{ $item['icon_active'] }}">
							{{ $item['name'] }}
						</a>
					<li>
				@else
					<li>
						<a href="{{ url('/'.$item['path']) }}">
						   <img src="{{ $item['icon_inactive'] }}">
						   {{ $item['name'] }}
						</a>
					<li>
				@endif
			@endforeach
		</ul>
	</section>
</aside>

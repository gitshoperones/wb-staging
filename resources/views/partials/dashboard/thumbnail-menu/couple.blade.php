@php
$requestPath = Request::path();
$menuItems = [
	[
		'path' => 'dashboard',
		'icon_active' => asset('assets/images/icons/dashboard/home2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/home_navy.png'),
		'name' => 'Home',
	],
	[
		'path' => 'dashboard/job-posts/create',
		'icon_active' => asset('assets/images/icons/dashboard/post_job2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/post_job_navy.png'),
		'name' => 'Post A New Job',
	],
	[
		'path' => 'suppliers-and-venues',
		'icon_active' => asset('assets/images/icons/dashboard/browse_sup2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/browse_sup_navy.png'),
		'name' => 'Browse Suppliers',
	],
	[
		'path' => 'dashboard/job-posts/live',
		'icon_active' => asset('assets/images/icons/dashboard/our_job_listings2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/our_job_listings_navy.png'),
		'name' => 'Our Live Jobs',
	],
	[
		'path' => 'dashboard/received-quotes',
		'icon_active' => asset('assets/images/icons/dashboard/sent_quotes2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/sent_quotes_navy.png'),
		'name' => 'Quotes Received',
	],
	[
	   'path' => 'dashboard/job-posts/draft',
	   'icon_active' => asset('assets/images/icons/dashboard/draft2.png'),
	   'icon_inactive' => asset('assets/images/icons/dashboard/draft_navy.png'),
	   'name' => 'Draft Jobs',
	],
	[
		'path' => 'dashboard/confirmed-bookings',
		'icon_active' => asset('assets/images/icons/dashboard/our_bookings2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/our_bookings_navy.png'),
		'name' => 'Confirmed Bookings',
	],
	// [
	// 	'path' => 'dashboard/favorite-vendors',
	// 	'icon_active' => asset('assets/images/icons/dashboard/favourites2.png'),
	// 	'icon_inactive' => asset('assets/images/icons/dashboard/favourites_navy.png'),
	// 	'name' => 'Our Favourites',
	// ],
	// [
	// 	'path' => 'dashboard/todo-list',
	// 	'icon_active' => asset('assets/images/icons/dashboard/todo2.png'),
	// 	'icon_inactive' => asset('assets/images/icons/dashboard/todo.png'),
	// 	'name' => 'To Do List',
	// ],
	[
		'path' => 'dashboard/invoices-and-payments',
		'icon_active' => asset('assets/images/icons/dashboard/payments2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/payments_navy.png'),
		'name' => 'Invoices & Payments',
	],
	// [
	// 	'path' => sprintf('couples/%s', $profile->id),
	// 	'icon_active' => asset('assets/images/icons/dashboard/our_profile2.png'),
	// 	'icon_inactive' => asset('assets/images/icons/dashboard/our_profile_navy.png'),
	// 	'name' => 'Our Profile',
	// ],
];
@endphp

<nav class="hide-desktop mobile mobilenav">
	<ul class="nav-wrapper-mobile">
		 @foreach($menuItems as $item)
			@if ($item['path'] === $requestPath)
				<li class="nav-item-mobile">
					<a class="item active" href="{{ url('/'.$item['path']) }}">
						<img src="{{ $item['icon_active'] }}">
						<span>{{ $item['name'] }}</span>
					</a>
				</li>
			@else
				<li class="nav-item-mobile">
					<a class="item"  href="{{ url('/'.$item['path']) }}">
					   <img src="{{ $item['icon_inactive'] }}">
					<span>{{ $item['name'] }}</span>
					</a>
				</li>
			@endif
		@endforeach
	</ul>
</nav><!-- /.hide-desktop mobile mobilenav -->
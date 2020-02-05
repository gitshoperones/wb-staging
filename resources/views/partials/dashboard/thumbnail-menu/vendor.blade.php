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
		'path' => 'dashboard/job-posts',
		'icon_active' => asset('assets/images/icons/dashboard/find_jobs2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/find_jobs_navy.png'),
		'name' => 'Find Work',
        'hidden' => Auth::user()->status === 'active' ? false : true
	],
	[
		'path' => 'dashboard/saved-jobs',
		'icon_active' => asset('assets/images/icons/dashboard/favourites2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/favourites_navy.png'),
		'name' => 'Saved Jobs',
		'hidden' => Auth::user()->status === 'active' ? false : true
	],
	[
		'path' => 'dashboard/sent-quotes',
		'icon_active' => asset('assets/images/icons/dashboard/sent_quotes2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/sent_quotes_navy.png'),
		'name' => 'Sent Quotes',
	],
	[
		'path' => 'dashboard/draft-quotes',
		'icon_active' => asset('assets/images/icons/dashboard/draft2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/draft_navy.png'),
		'name' => 'Drafts',
	],
	[
		'path' => 'dashboard/confirmed-bookings',
		'icon_active' => asset('assets/images/icons/dashboard/confirmed_work2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/confirmed_work_navy.png'),
		'name' => 'Confirmed Bookings',
	],
	// [
	//  'path' => 'dashboard/todo-list',
	//  'icon_active' => asset('assets/images/icons/dashboard/todo2.png'),
	//  'icon_inactive' => asset('assets/images/icons/dashboard/todo.png'),
	//  'name' => 'To Do List',
	// ],
	[
		'path' => 'dashboard/invoices-and-payments',
		'icon_active' => asset('assets/images/icons/dashboard/payments2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/payments_navy.png'),
		'name' => 'Invoices & Payments',
	],
	// [
	//  'path' => 'dashboard/reviews',
	//  'icon_active' => asset('assets/images/icons/dashboard/your_reviews2.png'),
	//  'icon_inactive' => asset('assets/images/icons/dashboard/your_reviews_navy.png'),
	//  'name' => 'Reviews',
	// ],
	[
		'path' => sprintf('vendors/%s', $loggedInUserProfile->id),
		'icon_active' => asset('assets/images/icons/dashboard/our_profile2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/our_profile_navy.png'),
		'name' => 'Our Profile',
	],
	[
		'path' => 'dashboard/verify-business',
		'icon_active' => asset('assets/images/icons/dashboard/lock2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/lock_navy.png'),
		'name' => 'Verify my business',
        'hidden' => Auth::user()->status === 'pending' ? false : true
	],
];
@endphp

<nav class="hide-desktop mobile mobilenav">
	<ul class="nav-wrapper-mobile">
		 @foreach($menuItems as $item)
            @php if (isset($item['hidden']) && $item['hidden'] === true) continue; @endphp
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
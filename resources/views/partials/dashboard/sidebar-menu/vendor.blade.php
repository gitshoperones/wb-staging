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
		'path' => 'dashboard/job-posts',
		'icon_active' => asset('assets/images/icons/dashboard/find_jobs2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/find_jobs.png'),
		'name' => 'Find Work',
		'hidden' => Auth::user()->status === 'active' ? false : true
	],
	[
		'path' => 'dashboard/saved-jobs',
		'icon_active' => asset('assets/images/icons/dashboard/favourites2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/favourites.png'),
		'name' => 'Saved Jobs',
		'hidden' => Auth::user()->status === 'active' ? false : true
	],
	[
		'path' => 'dashboard/sent-quotes',
		'icon_active' => asset('assets/images/icons/dashboard/sent_quotes2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/sent_quotes.png'),
		'name' => 'Sent Quotes',
	],
	[
		'path' => 'dashboard/draft-quotes',
		'icon_active' => asset('assets/images/icons/dashboard/draft2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/draft.png'),
		'name' => 'Drafts',
	],
	[
		'path' => 'dashboard/confirmed-bookings',
		'icon_active' => asset('assets/images/icons/dashboard/confirmed_work2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/confirmed_work.png'),
		'name' => 'Confirmed Bookings',
	],
	[
		'path' => 'dashboard/invoices-and-payments',
		'icon_active' => asset('assets/images/icons/dashboard/payments2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/payments.png'),
		'name' => 'Invoices & Payments',
	],
	[
		'path' => 'dashboard/todo-list',
		'icon_active' => asset('assets/images/icons/dashboard/todo2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/todo.png'),
		'name' => 'To Do List',
		'hidden' => true,
	],
	/*[
	   'path' => 'dashboard/reviews',
	   'icon_active' => asset('assets/images/icons/dashboard/your_reviews2.png'),
	   'icon_inactive' => asset('assets/images/icons/dashboard/your_reviews.png'),
	   'name' => 'Reviews',
	],*/
	[
		'path' => sprintf('vendors/%s', $loggedInUserProfile->id),
		'icon_active' => asset('assets/images/icons/dashboard/our_profile2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/our_profile.png'),
		'name' => 'Our Profile',
	],
	[
		'path' => 'dashboard/verify-business',
		'icon_active' => asset('assets/images/icons/dashboard/lock2.png'),
		'icon_inactive' => asset('assets/images/icons/dashboard/lock.png'),
		'name' => 'Verify my business',
		'hidden' => Auth::user()->status === 'pending' ? false : true
	],
];
@endphp
<aside class="main-sidebar" id="sidebar-wrapper">
	<section class="sidebar">
		<ul class="sidebar-menu">
			@foreach($menuItems as $item)
				@php if (isset($item['hidden']) && $item['hidden'] === true) continue; @endphp
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


<div id="wb-header" class="wb-header text-center frontend">
	<header class="container">
		<nav id="nav-links" class="nav-links navbar-static-top">
			<div class="left">
				<img rel="image_src" style="width: 0; height: 0; overflow: hidden; display: block;" src="{{ asset('/apple-touch-icon-180x180.png') }}" alt="" />
				<a href="{{ url('/') }}"><img src="{{ asset('assets/images/wb-logo.svg') }}" /></a>
			</div>
			<div class="right">
				<span class="hide-mobile">
					@guest
						@foreach($menus['guest']['name'] as $key => $menu)
							<a href="
							@foreach($menus['guest']['link'] as $link)
								{{ (substr($link->meta_key, strrpos($link->meta_key, "_") + 1) == substr($menu->meta_key, strrpos($menu->meta_key, "_") + 1)) ? strip_tags($link->meta_value) : ""  }}
							@endforeach
							">{!! strip_tags($menu->meta_value) !!}</a>
						@endforeach
					@endguest
					@couple
						@foreach($menus['couple']['name'] as $key => $menu)
							<a href="
							@foreach($menus['couple']['link'] as $link)
								{{ (substr($link->meta_key, strrpos($link->meta_key, "_") + 1) == substr($menu->meta_key, strrpos($menu->meta_key, "_") + 1)) ? strip_tags($link->meta_value) : ""  }}
							@endforeach
							">{!! strip_tags($menu->meta_value) !!}</a>
						@endforeach
					@endcouple
					@vendor
						@foreach($menus['vendor']['name'] as $key => $menu)
							<a href="
							@foreach($menus['vendor']['link'] as $link)
								{{ (substr($link->meta_key, strrpos($link->meta_key, "_") + 1) == substr($menu->meta_key, strrpos($menu->meta_key, "_") + 1)) ? strip_tags($link->meta_value) : ""  }}
							@endforeach
							">{!! strip_tags($menu->meta_value) !!}</a>
						@endforeach
					@endvendor
					<div class="supvenContainer @couple hide @endcouple">
						<a href="{!! $pageSettings->firstWhere('meta_key', 'sv_link') ? strip_tags($pageSettings->firstWhere('meta_key', 'sv_link')->meta_value) : '/suppliers-and-venues' !!}" class="supven">{!! $pageSettings->firstWhere('meta_key', 'sv_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'sv_text')->meta_value) : 'Suppliers & Venues' !!}</a>
						<div class="svDropdown">
							<div class="container">
								<div class="links">
								@foreach ($categories as $category)
								<a href="/suppliers-and-venues?expertise%5B%5D={{ $category['name'] }}">
									{{ $category['name'] }}
								</a>
								@endforeach
								</div>
								<a href="/suppliers-and-venues" class="viewall">View all Suppliers and Venues...</a>
							</div>
						</div>
					</div>
				</span>
				@guest
				<span class="hide-mobile">
					<a data-toggle="modal" data-target="#start-planning-select" class="btn wb-btn-orange mini">{!! $pageSettings->firstWhere('meta_key', 'signup_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'signup_text')->meta_value) : 'Get Started' !!}</a>
					<a href="{!! $pageSettings->firstWhere('meta_key', 'login_link') ? strip_tags($pageSettings->firstWhere('meta_key', 'login_link')->meta_value) : '/login' !!}" class="btn wb-btn-primary mini">{!! $pageSettings->firstWhere('meta_key', 'login_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'login_text')->meta_value) : 'Login' !!}</a>
				</span>
				@endguest
				@auth
				@php
					$meta_dashboard = (auth()->user()->account == 'couple') ? 'dashboard_text_couple' : 'dashboard_text_vendor' ;
					$totalNotifications = $notificationsCount + $messagesCount;
				@endphp
				<a class="btn wb-btn-primary mini front-notifications" href="{{ url('/dashboard') }}">{!! $pageSettings->firstWhere('meta_key', $meta_dashboard) ? strip_tags($pageSettings->firstWhere('meta_key', $meta_dashboard)->meta_value) : 'My Dashboard' !!}
				@if ($totalNotifications > 0)
					<span class="label label-orange">{{ $totalNotifications }}</span>
				@endif

				</a>
				@endauth

				<div class="login @guest hide-desktop @endguest">
					<div class="icon-wrapper">
						<span class="useravatar" style="vertical-align: middle;">
							<a href="#" class="icon avatar front-menu" data-toggle="dropdown">
								<i class="fa fa-bars"></i>
							</a>
							<ul class="submenu">
								@auth
								<li class="li-avatar">
									<div class="avatar-img">
										@if($loggedInUserProfile && $loggedInUserProfile->profile_avatar)
										<img src="{{ $loggedInUserProfile->profile_avatar }}" class="img-square" />
										@else
										<img src="https://s.gravatar.com/avatar/94122f32bdba75d273960c141f29473e?s=170"  class="img-square" />
										@endif
									</div>
									<div class="name">
										@vendor
										<a href="{{ url(sprintf('/%ss/%s', Auth::user()->account, $loggedInUserProfile ? $loggedInUserProfile->id : null)) }}" style="padding: unset;">
											{{ $loggedInUserProfile->business_name }} </a>
										@endvendor
                                        @if (Auth::user()->account === 'parent')
                                            {{ $loggedInUserProfile->business_name }}
                                        @endif
										@couple
										<a href="{{ url('/dashboard') }}" style="padding: unset;">
											{{ Auth::user()->coupleProfile()->title }} </a>
										@endcouple
										@guest
										Welcome Guest
										@endguest
									</div>
								</li>
								@endauth

								@guest
									@foreach($menus['guest']['name'] as $key => $menu)
										<li class="hide-desktop mobile">
											<a class="mobile-link sub-link" href="
												@foreach($menus['guest']['link'] as $link)
													{{ (substr($link->meta_key, strrpos($link->meta_key, "_") + 1) == substr($menu->meta_key, strrpos($menu->meta_key, "_") + 1)) ? strip_tags($link->meta_value) : ""  }}
												@endforeach
												">{!! strip_tags($menu->meta_value) !!}</a>
										</li>
									@endforeach
								@endguest
								@couple
									@foreach($menus['couple']['name'] as $key => $menu)
										<li class="hide-desktop mobile">
											<a class="mobile-link sub-link" href="
												@foreach($menus['couple']['link'] as $link)
													{{ (substr($link->meta_key, strrpos($link->meta_key, "_") + 1) == substr($menu->meta_key, strrpos($menu->meta_key, "_") + 1)) ? strip_tags($link->meta_value) : ""  }}
												@endforeach
												">{!! strip_tags($menu->meta_value) !!}</a>
										</li>
									@endforeach
								@endcouple
								@vendor
									@foreach($menus['vendor']['name'] as $key => $menu)
										<li class="hide-desktop mobile">
											<a class="mobile-link sub-link" href="
												@foreach($menus['vendor']['link'] as $link)
													{{ (substr($link->meta_key, strrpos($link->meta_key, "_") + 1) == substr($menu->meta_key, strrpos($menu->meta_key, "_") + 1)) ? strip_tags($link->meta_value) : ""  }}
												@endforeach
												">{!! strip_tags($menu->meta_value) !!}</a>
										</li>
									@endforeach
								@endvendor

								<li class="hide-desktop mobile">
									<a class="mobile-link sub-link" href="{!! $pageSettings->firstWhere('meta_key', 'sv_link') ? strip_tags($pageSettings->firstWhere('meta_key', 'sv_link')->meta_value) : '/suppliers-and-venues' !!}">{!! $pageSettings->firstWhere('meta_key', 'sv_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'sv_text')->meta_value) : 'Suppliers & Venues' !!}</a>
								</li>

								@guest

								<li class="hide-desktop">
									<a class="mobile-link sub-link bg-coral" style="color: #ffffff" data-toggle="modal" data-target="#start-planning-select">{!! $pageSettings->firstWhere('meta_key', 'signup_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'signup_text')->meta_value) : 'Get Started' !!}</a>
								</li>

								<li class="hide-desktop">
									<a class="mobile-link sub-link bg-navy" href="{!! $pageSettings->firstWhere('meta_key', 'login_link') ? strip_tags($pageSettings->firstWhere('meta_key', 'login_link')->meta_value) : '/login' !!}">{!! $pageSettings->firstWhere('meta_key', 'login_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'login_text')->meta_value) : 'Login' !!}</a>
								</li>
								@endguest
								@auth
                                    @if (Auth::user()->account === 'parent')
                                        <li>
                                            <a href="{{ url('/business-settings') }}" class="sub-link">Settings</a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ url('/user-settings') }}" class="sub-link">Settings</a>
                                        </li>
                                    @endif
									<li>
										@impersonating
											<a href="{{ url('/impersonation/leave') }}" class="sub-link">
												Back to master account
											</a>
										@else
											<a href="{{ url('/logout') }}" class="sub-link sign-out">Sign Out</a>
										@endImpersonating
									</li>
								@endauth
							</ul>
						</span>

					</div>
				</div>

			</div>
		</nav>
	</header>
</div>

@include('modals.start-planning')

@guest
@include('modals.start-planning-select')
@endguest

@push('scripts')
<script>
	$(document).scroll(function () {
		var $nav = $(".wb-header");
		$nav.toggleClass('sticky', $(this).scrollTop() > $nav.height());
	});

	var formId = '';
	$('.frontend .hide-desktop.mobile').last().addClass('last');
	
	$('.get-quote, .quote-next').click(function(e) {
		var	selector = ($(this).hasClass('get-quote')) ? '#get-quote' : '#quote-next',
			category = $(`${selector} input[name="category"]:checked`).val(),
			location = $(`${selector} input[name="locations[]"]:checked`).val();

		if(category != undefined && location != undefined) {
			formId = selector;
			
			setTimeout(function() {
				$('body').addClass('modal-open');
			}, 400);
			
			$('.modal-category').text(category);
			$('.modal-location').text(($(`${selector} input[name="locations[]"]:checked`).length == 1) ? ` in ${ location } ...` : '' );
		}else {
			alert('Please select category and location')
			return false
		}
	});

	$('.tell-us').click(function(e) {
		var form = $(formId);

		$(this).attr('form', formId);
		form.attr('action', '{{ (Auth::check()) ? '/dashboard/job-posts/create' : '/job-posts/create' }}');
		form.submit();
	});

	$('.browse-us').click(function(e) {
		var form = $(formId),
			category = $(`${formId} input[name="category"]:checked`);

		$(this).attr('form', formId);
		category.attr('name', 'expertise[]');
		form.attr('action', '/suppliers-and-venues');
		form.submit();
	});

	$(document).on('click', 'dt a.dropdown', function(){
		$('.selectdropdown dd div > ul').hide();
		$(this).closest('.selectdropdown').find('dd div > ul').slideToggle('fast');
	});

	$('.statename .toggleLocations').click(function () {
		$(this).find('i').toggleClass('fa-plus fa-minus');
		$(this).closest('.statename').find('> ul').slideToggle('fast');
	});

	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (!$clicked.parents().hasClass("selectdropdown")) $(".selectdropdown dd div > ul").hide();
	});

	$(document).on('click', '.mutliSelect input[type="checkbox"], .mutliSelect input[type="radio"]', function(){
		var title = $(this).val()
			inputType = $(this).attr('type');
			selectdropdown = $(this).closest('.selectdropdown');

		if ($(this).is(':checked')) {
			var html = `<span title="${ title }">${ title }${ (inputType == 'checkbox') ? ', ' : '' }</span>`;

			if (inputType == 'radio')
				selectdropdown.find('.multiSel .categs').html(html);
			else
				selectdropdown.find('.multiSel').append(html);

			selectdropdown.find('.multiSel span[title="wedBooker"]').hide();
		} else {
			selectdropdown.find(`.multiSel span[title="${title}"]`).remove();
			if(inputType == 'radio' || (inputType == 'checkbox' && $(this).closest('.mutliSelect').find('input[type="checkbox"]:checked').length < 1)) {
				selectdropdown.find('.multiSel span[title="wedBooker"]').show();
			}
		}

		$(".selectdropdown dd div > ul").hide()
	});
</script>
@endpush
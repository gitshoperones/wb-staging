<header class="main-header dashboard">
	<nav role="navigation" class="navbar navbar-static-top">
		<div class="wb-logo-wrapper">
			<a href="{{ url('/') }}" class="dash-logo">
				<img src="{{ asset('assets/images/wb-logo.svg') }}">
			</a>
		</div>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav dashnav">
				
				{{-- @if(isset($loggedInUserProfile->onboarding) && $loggedInUserProfile->onboarding)
				<li class="dash-search">
					<div class="nav-search">
						<dl class="selectdropdown suppliervenue">
							<dt>
								<a class="dropdown">
									<p class="multiSel text-center" id="sup-ven">
										<i class="fa fa-search text-primary"></i>
										<span title="Search Suppliers and Venues"> Suppliers & Venues</span>
									</p>
								</a>
							</dt>
							<dd>
								<div class="mutliSelect">
									<ul>
										<li>
											<label data-href="/suppliers-and-venues" style="text-transform: capitalize; padding: 0; width: 100%; cursor: pointer;">All Suppliers & Venues</label>
										</li>
										@foreach ($categories as $category)
										<li>
											<label data-href="/suppliers-and-venues?expertise%5B%5D={{ $category['name'] }}" style="text-transform: capitalize; padding: 0; width: 100%; cursor: pointer;">{{ $category['name'] }}</label>
										</li>
										@endforeach
									</ul>
								</div>
							</dd>
						</dl>
					</div>
				</li>
				@endif
				
				@couple
				<li class="post-a-job">
					<a href="{!! $pageSettings->firstWhere('meta_key', 'pj_link') ? strip_tags($pageSettings->firstWhere('meta_key', 'pj_link')->meta_value) : '/dashboard/job-posts/create' !!}" class="btn wb-btn-orange mini front-notifications">{!! $pageSettings->firstWhere('meta_key', 'pj_text') ? strip_tags($pageSettings->firstWhere('meta_key', 'pj_text')->meta_value) : 'Post A Job' !!}</a>
				</li>
				<li class="faves">
					<a href="{{ url('/dashboard/favorite-vendors') }}" class="dropdown-toggle favorites">
						<i class="fa fa-heart"></i>
					</a>
				</li>
				@endcouple --}}
				@if (Auth::user()->account !== 'parent')
				<li>
					<a href="{{ url('/dashboard/notifications') }}" class="dropdown-toggle notifications">
						<i class="fa fa-bell"></i>
						@if ($notificationsCount > 0)
						<span class="label label-orange">{{ $notificationsCount }}</span>
						@endif
					</a>
				</li>
				<li>
					<a href="{{ url('/dashboard/messages') }}" class="dropdown-toggle messages">
						<i class="fa fa-envelope"></i>
						@if ($messagesCount > 0)
						<span class="label label-orange">{{ $messagesCount }}</span>
						@endif
					</a>
				</li>
                @endif
				{{-- <li>
					<a href="#" data-toggle="modal" data-target="#searchModal"  class="dropdown-toggle search">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">.st0{fill:#fff;}</style><path fill="#fff" class="st0" d="M31.4,28.6l-7.9-7.9c1.6-2.1,2.5-4.8,2.5-7.7c0-7.2-5.8-13-13-13C5.8,0,0,5.8,0,13s5.8,13,13,13  c2.9,0,5.5-0.9,7.7-2.5l7.9,7.9c0.8,0.8,2,0.8,2.8,0S32.2,29.4,31.4,28.6z M4,13c0-5,4-9,9-9c5,0,9,4,9,9s-4,9-9,9C8,22,4,18,4,13z"/>
						</svg>
					</a>
				</li> --}}
				<li class="dropdown user user-menu useravatar">
					<a href="{{ url('/dashboard') }}" data-toggle="dropdown" class="" style="height: 100%; background-color: transparent;">
						<i class="fa fa-bars"></i>
					</a>
					<ul class="submenu">
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
								<a href="{{ url(sprintf('/%ss/%s', Auth::user()->account, $loggedInUserProfile->id)) }}" class="">
									{{ $loggedInUserProfile->business_name }} </a>
								@endvendor
                                @if (Auth::user()->account === 'parent')
									{{ $loggedInUserProfile->business_name }}
                                @endif
								@couple
								<a href="{{ url('/dashboard') }}" class="">
									{{ Auth::user()->coupleProfile()->title }} </a>
								@endcouple
								@guest
								    Welcome Guest
								@endguest
							</div>
						</li>
						<li class="hide-desktop mobile">
							<a href="{{ url('/dashboard') }}" class="sub-link">My Dashboard</a>
						</li>
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
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	@couple
	@include('partials.dashboard.thumbnail-menu.couple')
	@endcouple

	@vendor
	@include('partials.dashboard.thumbnail-menu.vendor')
	@endvendor

	@if (session('parentImpersonation') && session('parentImpersonation') === true)
    <div class="subhead-impersonate">
        <span><strong>Managing: {{ Auth::user()->vendorProfile->business_name }}</strong></span>
        <a href="{{ url('/impersonation/leave') }}" class="btn wb-btn-white disable-onclick">
            SWITCH ACCOUNTS
        </a>
    </div>
	@endif
</header>

@push('scripts')
<script>
	$(document).scroll(function () {
		var $nav = $(".main-header.dashboard");
		$nav.toggleClass('sticky', $(this).scrollTop() > $nav.height()-50);
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

	$(".suppliervenue dd label").click(function () {
		var red = $(this).data('href');
		window.location.href = red;
	})
</script>
@endpush
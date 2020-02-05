<!-- User Account Menu -->
<li class="dropdown user user-menu">
	<!-- Menu Toggle Button -->
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<!-- The user image in the navbar-->
		@if(Auth::user()->avatar)
		<img id="avatarImg" src="{{ Auth::user()->avatar }}" class="img-square " alt="no image">
		@else
		<img id="avatarImg" src="https://s.gravatar.com/avatar/94122f32bdba75d273960c141f29473e?s=170" class="img-square" alt="no image">
		@endif
		<span class="arrow-down"><i class="fa fa-chevron-down"></i></span>
		<!-- hidden-xs hides the username on small devices so only the image appears. -->
		<span class="hidden-xs">{!! Auth::user()->name !!}</span>
	</a>
	<ul class="dropdown-menu">
		<!-- The user image in the menu -->
		<li class="user-header">
			<!-- The user image in the navbar-->
			@if(Auth::user()->avatar)
			<img id="avatarImg" src="{{ Auth::user()->avatar }}" class="img-square " alt="no image">
			@else
			<img id="avatarImg" src="https://s.gravatar.com/avatar/94122f32bdba75d273960c141f29473e?s=170" class="img-square" alt="no image">
			@endif
		</li>
		<!-- Menu Footer-->
		<li class="user-footer">
			<div class="pull-left">
				<a href="#" class="btn btn-default btn-flat">Profile</a>
			</div>
			<div class="pull-right">
				<a href="{{ url('/logout') }}" class="btn btn-default btn-flat sign-out">
					Sign out
				</a>
			</div>
		</li>
	</ul>
</li>
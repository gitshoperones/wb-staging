<div class="mini-wb-profile-box wb-profile-box box box-widget {{ Auth::user()->account }}">
    <a href="{{ url(sprintf('/%ss/%s/edit', Auth::user()->account, $loggedInUserProfile->id)) }}">
        <span class="edit-icon"><i class="fa fa-pencil"></i></span>
    </a>
	<div class="profile-img">
		<a href="{{ url(sprintf('/%ss/%s', Auth::user()->account, $loggedInUserProfile->id)) }}" class="myprofile btn wb-btn-glass-white">
            View Our Profile
        </a>
		<img id="avatarImg"
			height="120px" width="120px" alt="no image"
			@if ($loggedInUserProfile->profile_avatar)
				src="{{ $loggedInUserProfile->profile_avatar }}"
			@else
				src="https://s.gravatar.com/avatar/94122f32bdba75d273960c141f29473e?s=170"
			@endif
		class="img-square editOff">
	</div>
	<div class="name">
		{{ $loggedInUserProfile->business_name}}
	</div>
	<div class="location tooltip-holder">
        {{
            isset($loggedInUserProfile->locations[0])
            ? $loggedInUserProfile->locations[0]->name
            : ''
        }}
		@if(count($loggedInUserProfile->locations) > 1)
			<br/>
			{{ count($loggedInUserProfile->locations) - 1 }} more location(s)
			<div class="tooltip-alt" style="padding: 10px;">
				Your service regions are set to
                {{
                    $loggedInUserProfile->locations->forget(0)->map(function ($item) {
                        return ['d' => $item['name']];
                    })->implode('d', ', ')
                }}
			</div>
		@endif
	</div>
    @include('partials.profiles.vendor-stars', ['hideModal' => true])
</div>


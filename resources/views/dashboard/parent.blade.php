@extends('layouts.parent')

@section('content')
<section class="content ">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			@include('partials.alert-messages')
			<br />
			<div class="text-center parent-name">
				<div class="">{{ Auth::user()->vendorProfile->business_name }}</div>
			</div>
			   <br />
			@foreach($childAccounts as $account)
				<div class="col-md-3">
					<div class="mini-wb-profile-box wb-profile-box box box-widget vendor">
						<a href="{{ url(sprintf('/impersonation/%s', $account->childVendorProfile->user_id)) }}"
							class="label wb-btntline-pink">
							<i class="fa fa-bell"></i>
							{{ $account->childVendorProfile->user->unreadNotifications->where('type', '<>', 'Musonza\\Chat\\Notifications\\MessageSent')->count() }}
						</a>&nbsp;
						<a href="{{ url(sprintf('/impersonation/%s?url=%s', $account->childVendorProfile->user_id, '/dashboard/messages')) }}"
							class="label wb-btntline-pink">
							<i class="fa fa-envelope"></i>
							{{ $account->childVendorProfile->user->unreadNotifications->where('type', 'Musonza\\Chat\\Notifications\\MessageSent')->count() }}
						</a><br/> <br/>
						<img id="avatarImg"
							height="120px" width="120px" alt="no image"
							@if ($account->childVendorProfile->profile_avatar)
								src="{{ $account->childVendorProfile->profile_avatar }}"
							@else
								src="https://s.gravatar.com/avatar/94122f32bdba75d273960c141f29473e?s=170"
							@endif
						class="img-square editOff">
						<div class="name">
							{{ $account->childVendorProfile->business_name}}
						</div>
						<a class="btn btn-orange disable-onclick" href="{{ url(sprintf('/impersonation/%s', $account->childVendorProfile->user_id)) }}">
							View Account
						</a>
					</div>
				</div>
			@endforeach
		<div>
	</div>
</section>
@endsection

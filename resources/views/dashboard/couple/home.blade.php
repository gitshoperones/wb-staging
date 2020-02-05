@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	<div class="row row-no-padding">
		<div class="col-sm-12 col-md-3">
			@include(sprintf('partials.dashboard.%s-profile', Auth::user()->account))
			<div class="hide-mobile">@include('partials.dashboard.useful-links')</div><!-- /.hide-mobile -->
		</div>
		<div class="col-sm-12 col-md-9">
			@include('partials.dashboard.notifications')
			<div class="hide-desktop">@include('partials.dashboard.useful-links')</div><!-- /.hide-mobile -->
		</div>
	</div>
    @if (!$loggedInUserProfile->onboarding)
        @include('onboarding.couple')
    @endif
    @if ($errors->any())
        @include('modals.alert-messages')
    @endif
</section>
@endsection


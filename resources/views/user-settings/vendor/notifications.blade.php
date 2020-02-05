@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
	<div class="container">
		<div class="text-center">
			@include('partials.user-settings.vendor-tab-header')
			<div class="row">
				<div class="notification-container wb-box">
					@include('modals.alert-messages')
                    <form method="POST" action="{{ url('notification-settings') }}" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PATCH">
                        {{ csrf_field() }}
                        
                        <h4 class="title">Additional Emails to Receive Notifications</h4>
                        <p class="text-primary">Notifications will be sent to the primary email address for this account. You can also specify two other email addresses to receive notifications</p>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group" title="Email Address 1" data-toggle="tooltip">
                                    {{-- <label for="email[]">Email Address 1:</label> --}}
                                    <input name="email[]"
                                        type="text"
                                        placeholder="Email Address 1"
                                        class="form-control"
                                        value="{{ isset(old('email')[0]) ? old('email')[0] : (isset($emails[0]) ? $emails[0] : null) }}">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group" title="Email Address 2" data-toggle="tooltip">
                                    {{-- <label for="email[]">Email Address 2:</label> --}}
                                    <input name="email[]"
                                        type="text"
                                        placeholder="Email Address 2"
                                        class="form-control"
                                        value="{{ isset(old('email')[1]) ? old('email')[1] : (isset($emails[1]) ? $emails[1] : null) }}">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <input type="submit" value="SAVE CHANGES" class="btn wb-btn-orange">
                            </div>
                        </div>

                        {{-- <h4 class="title">Please select how often you'd like to be notified of events in your account, such as activity around your quotes, bookings and payments.</h4>
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="radiobox">
                                        <input
                                            @if (!$notificationSetting
                                                || $notificationSetting && $notificationSetting->meta_value === 'immediate')
                                                checked
                                            @endif
                                            id="immediate" name="notification" type="radio" value="immediate">
                                        <label for="immediate">Send me an email as soon as an event occurs in my account</label>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="radiobox">
                                        <input
                                            @if ($notificationSetting && $notificationSetting->meta_value === 'once daily')
                                                checked
                                            @endif
                                            id="once-daily" name="notification" type="radio" value="once daily">
                                        <label for="once-daily">Once a day summary (we only email you if there is new activity in your account)</label>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="radiobox">
                                        <input
                                            @if ($notificationSetting && $notificationSetting->meta_value === 'twice daily')
                                                checked
                                            @endif
                                            id="twice-daily" name="notification" type="radio" value="twice daily">
                                        <label for="twice-daily">Twice a day summary (we only email you if there is new activity in your account)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>Notifications will be sent to the email address you signed up to wedBooker</p> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
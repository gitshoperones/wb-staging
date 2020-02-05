@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
    <div class="container">
        <div class="text-center">
            @include('partials.user-settings.couple-tab-header')
            <div class="row">
                <div class="notification-container wb-box">
                    <p class="text-primary">Notifications will be sent to the email address you signed up to wedBooker</p>

                    @include('modals.alert-messages')
                    {{-- <form method="POST" action="{{ url('notification-settings') }}" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PATCH">
                        {{ csrf_field() }}
                        <h4 class="title">Please select how often you'd like to be notified of events in your account, such as activity around your quotes, bookings and payments.</h4>
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
                        <p>Notifications will be sent to the email address you signed up to wedBooker with</p>
                        <div class="action-block" style="margin-bottom: 0;">
                            <p></p>
                            <input type="submit" value="SAVE CHANGES" class="btn wb-btn-orange">
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
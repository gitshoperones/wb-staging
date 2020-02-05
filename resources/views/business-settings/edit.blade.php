@extends('layouts.public')

@section('content')

@include('modals.alert-messages')

<section id="wb-settings-block">
    <div class="container">
        <form method="POST" action="{{ url('business-settings') }}" accept-charset="UTF-8">
            <div class="row">
                <div class="wb-box" style="padding: 30px 32px; margin-bottom: 100px;">
                    <h4 class="title">Notification Settings</h4>
                    <input type="hidden" name="_method" value="PATCH">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email address for notifications</label>
                                <p><small>(Add an email here to receive all emails from your child accounts, leave empty to stay default)</small></p>
                                <input name="email"
                                    type="text"
                                    class="form-control"
                                    value="{{ $email }}">
                            </div>
                        </div>
                    </div>
                    <h4 class="title">Password Settings</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="existing_password">Existing Password</label>
                                <input name="existing_password"
                                    type="password"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input name="password"
                                    type="password"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Pasword</label>
                                <input name="password_confirmation"
                                    type="password"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn wb-btn-orange">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
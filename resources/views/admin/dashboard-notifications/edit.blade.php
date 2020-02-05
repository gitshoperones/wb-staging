@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Edit Dashboard Notification')
@push('css')
    <style>
        .form-group input[type="checkbox"] {
            display: none;
        }
        .form-group input[type="checkbox"] + .btn-group > label span {
            width: 20px;
        }
        .form-group input[type="checkbox"] + .btn-group > label span:first-child {
            display: none;
        }
        .form-group input[type="checkbox"] + .btn-group > label span:last-child {
            display: inline-block;
        }
        .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
            display: inline-block;
        }
        .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
            display: none;
        }
        #recipients-checkbox .btn-group {
            margin-right: 15px;
        }
    </style>
@endpush
@section('content')
    @include('partials.alert-messages')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 form-group" id="text-setting-type">
                <form method="POST" action="{{ url(sprintf('/admin/dashboard-notifications/%s/update', $dashboard_notification->id)) }}" accept-charset="UTF-8">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ $dashboard_notification->subject }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="button">Button</label>
                                <input type="text" class="form-control" id="button" name="button" value="{{ $dashboard_notification->button }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="recipients-checkbox">Send in</label>
                        <div id="recipients-checkbox">
                            <input type="checkbox" name="frequencies[]" value="realtime" id="fancy-checkbox-real-time" autocomplete="off"
                                @if(in_array('realtime', explode(',', $dashboard_notification->frequency))) checked @endif/>
                            <div class="btn-group">
                                <label for="fancy-checkbox-real-time" class="btn btn-default">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-real-time" class="btn btn-default active">
                                    Real Time
                                </label>
                            </div>

                            <input type="checkbox" name="frequencies[]" value="summary" id="fancy-checkbox-summary" autocomplete="off"
                                @if(in_array('summary', explode(',', $dashboard_notification->frequency))) checked @endif/>
                            <div class="btn-group">
                                <label for="fancy-checkbox-summary" class="btn btn-default">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-summary" class="btn btn-default active">
                                    Summary
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label for="recipients-checkbox">recipient</label>
                        <div id="recipients-checkbox">
                            <input type="checkbox" name="recipient[]" value="admin" id="fancy-checkbox-admin" autocomplete="off"
                                @if(in_array('admin', explode(',', $dashboard_notification->recipient))) checked @endif/>
                            <div class="btn-group">
                                <label for="fancy-checkbox-admin" class="btn btn-default">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-admin" class="btn btn-default active">
                                    Admin
                                </label>
                            </div>

                            <input type="checkbox" name="recipient[]" value="vendor" id="fancy-checkbox-vendor" autocomplete="off"
                                @if(in_array('vendor', explode(',', $dashboard_notification->recipient))) checked @endif/>
                            <div class="btn-group">
                                <label for="fancy-checkbox-vendor" class="btn btn-default">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-vendor" class="btn btn-default active">
                                    Vendor
                                </label>
                            </div>

                            <input type="checkbox" name="recipient[]" value="parent" id="fancy-checkbox-parent" autocomplete="off"
                                @if(in_array('parent', explode(',', $dashboard_notification->recipient))) checked @endif/>

                            <div class="btn-group">
                                <label for="fancy-checkbox-parent" class="btn btn-default">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-parent" class="btn btn-default active">
                                    Parent
                                </label>
                            </div>

                            <input type="checkbox" name="recipient[]" value="couple" id="fancy-checkbox-couple" autocomplete="off"
                                @if(in_array('couple', explode(',', $dashboard_notification->recipient))) checked @endif/>

                            <div class="btn-group">
                                <label for="fancy-checkbox-couple" class="btn btn-default">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-couple" class="btn btn-default active">
                                    Couple
                                </label>
                            </div>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" cols="5" rows="15" id="editor" name="body">{{ $dashboard_notification->body }}</textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a type="submit" class="btn btn-danger" href="{{ url('admin/automated-notifications')}} ">Cancel</a>
                        <!-- <a type="submit" class="btn btn-danger" href="{{ url('admin/emails')}} ">Cancel</a> -->
                    </div>
                </form>
            </div>

            <div class="col-lg-4 form-group">
                <h4>Subject Tokens: </h4>
                @if(!is_null($dashboard_notification->tokens_subject))
                    <ul>
                        @foreach(explode(",", $dashboard_notification->tokens_subject) as $token)
                            <li>{{ $token }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No available</p>
                @endif

                <h4>Body Tokens: </h4>
                @if(!is_null($dashboard_notification->tokens_body))
                    <ul>
                        @foreach(explode(",", $dashboard_notification->tokens_body) as $token)
                            <li>{{ $token }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No available</p>
                @endif
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

    <script type="text/javascript">
        $('#body').summernote({
            height: 300
        });
    </script>
@endpush

@include('partials.admin.footer')
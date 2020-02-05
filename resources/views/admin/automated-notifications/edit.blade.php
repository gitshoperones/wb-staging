@extends('adminlte::page')

@include('partials.admin.header')

@section('title', 'Edit Automated Notification')

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
        .notification-details{
            background: #fff;
            padding: 10px;
            border: 1px solid #9999;
            border-radius: 3px;
            margin-bottom: 30px;
        }
        .notification-details span{
            font-size: 12px;
            font-style: italic;
        }
        .notification-details h4{
            margin-top: 0;
        }
    </style>
@endpush

@section('content')
    @include('partials.alert-messages')
    <div class="">
        <form method="POST" action="{{ url(sprintf('/admin/automated-notifications/%s/update', $event->id)) }}" class="notification-details">
            @method('patch')
            @csrf
            <span>Trigger:</span>
                <h4>{{ $event->name }}</h4>
            <span>Description:</span>
            <div class="form-group">
                <input type="text" class="form-control" id="description" name="description" value="{{ $event->description }}">
            </div>
            <input type="submit" class="btn btn-primary" value="Save">
        </form>
        @foreach($merged_notifications as $item)
            @if($item->type == 'dashboard')
                <div class="row">
                    <div class="col-lg-8 form-group" id="text-setting-type">
                        <h4>Dashboard Notification to {{ $item->recipient }}</h4>
                        <form method="POST" action="{{ url(sprintf('/admin/dashboard-notifications/%s/update', $item->id)) }}" accept-charset="UTF-8">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="subject_{{ $item->id }}">Subject</label>
                                        <input type="text" class="form-control" id="subject_{{ $item->id }}" name="subject" value="{{ $item->subject }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="button_{{ $item->id }}">Button</label>
                                        <input type="text" class="form-control" id="button_{{ $item->id }}" name="button" value="{{ $item->button }}" required>
                                    </div>
                                </div>
                                @if($item->button2 !== null)
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="button2_{{ $item->id }}">Button 2</label>
                                            <input type="text" class="form-control" id="button2_{{ $item->id }}" name="button2" value="{{ $item->button2 }}" required>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- <div class="form-group">
                                <label for="recipients-checkbox">Send in</label>
                                <div id="recipients-checkbox">
                                    <input type="checkbox" name="frequencies[]" value="realtime" id="fancy-checkbox-real-time" autocomplete="off"
                                        @if(in_array('realtime', explode(',', $item->frequency))) checked @endif/>
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
                                        @if(in_array('summary', explode(',', $item->frequency))) checked @endif/>
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
                            </div> --}}

                            <div class="form-group">
                                <div id="recipients-checkbox">
                                    <input type="checkbox" name="status" id="status-{{ $item->id }}" autocomplete="off"
                                        @if($item->status) checked @endif/>
                                    <div class="btn-group">
                                        <label for="status-{{ $item->id }}" class="btn btn-default">
                                            <span class="glyphicon glyphicon-ok"></span>
                                            <span> </span>
                                        </label>
                                        <label for="status-{{ $item->id }}" class="btn btn-default active">
                                            On
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label for="recipients-checkbox">recipient</label>
                                <div id="recipients-checkbox">
                                    <input type="checkbox" name="recipient[]" value="admin" id="fancy-checkbox-admin" autocomplete="off"
                                        @if(in_array('admin', explode(',', $item->recipient))) checked @endif/>
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
                                        @if(in_array('vendor', explode(',', $item->recipient))) checked @endif/>
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
                                        @if(in_array('parent', explode(',', $item->recipient))) checked @endif/>

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
                                        @if(in_array('couple', explode(',', $item->recipient))) checked @endif/>

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
                                <textarea class="form-control" cols="5" rows="15" id="editor" name="body">{{ $item->body }}</textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a type="submit" class="btn btn-danger" href="{{ url('admin/automated-notifications')}} ">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 form-group">
                        <h4>Subject Tokens: </h4>
                        @if(!is_null($item->tokens_subject))
                            <ul>
                                @foreach(explode(",", $item->tokens_subject) as $token)
                                    <li>{{ $token }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No available</p>
                        @endif

                        <h4>Body Tokens: </h4>
                        @if(!is_null($item->tokens_body))
                            <ul>
                                @foreach(explode(",", $item->tokens_body) as $token)
                                    <li>{{ $token }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No available</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 form-group" id="text-setting-type">
                        <h4>Email Notification to {{ $item->recipient }}</h4>
                        <form method="POST" action="{{ url(sprintf('/admin/emails/%s/update', $item->id)) }}" accept-charset="UTF-8">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="subject">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject" value="{{ $item->subject }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="button">Button Text</label>
                                        <input type="text" class="form-control" id="button" name="button" value="{{ $item->button }}" required>
                                    </div>
                                    {{-- <div class="col-lg-4">
                                        <label for="email-template">Email Template</label>
                                        <select class="form-control" id="email-template" name="email_template_id">
                                            @foreach($email_templates as $email_template)
                                                <option value="{{ $email_template->id }}" {{ ($email_template->id == $item->email_template->id) ? "selected" : "" }}>{{ $email_template->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="form-group">
                            </div>
                            
                            {{--
                            <div class="form-group">
                                <label for="recipients-checkbox">Send in</label>
                                <div id="recipients-checkbox">
                                    <input type="checkbox" name="frequencies[]" value="realtime" id="fancy-checkbox-real-time" autocomplete="off"
                                        @if(in_array('realtime', explode(',', $item->frequency))) checked @endif/>
                                    <div class="btn-group">
                                        <label for="fancy-checkbox-real-time" class="btn btn-default">
                                            <span class="glyphicon glyphicon-ok"></span>
                                            <span> </span>
                                        </label>
                                        <label for="fancy-checkbox-real-time" class="btn btn-default active">
                                            Real Times
                                        </label>
                                    </div>

                                    <input type="checkbox" name="frequencies[]" value="summary" id="fancy-checkbox-summary" autocomplete="off"
                                        @if(in_array('summary', explode(',', $item->frequency))) checked @endif/>
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
                            </div> --}}
                            

                            {{-- <div class="form-group">
                                <label for="recipients-checkbox">recipient</label>
                                <div id="recipients-checkbox">
                                    <input type="checkbox" name="recipient[]" value="admin" id="fancy-checkbox-admin" autocomplete="off"
                                        @if(in_array('admin', explode(',', $item->recipient))) checked @endif/>
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
                                        @if(in_array('vendor', explode(',', $item->recipient))) checked @endif/>
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
                                        @if(in_array('parent', explode(',', $item->recipient))) checked @endif/>

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
                                        @if(in_array('couple', explode(',', $item->recipient))) checked @endif/>

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
                                <textarea class="form-control email-body" id="body" cols="5" rows="15" name="body">{{ $item->body }}</textarea>
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
                        @if(!is_null($item->tokens_subject))
                            <ul>
                                @foreach(explode(",", $item->tokens_subject) as $token)
                                    <li>{{ $token }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No available</p>
                        @endif

                        <h4>Body Tokens: </h4>
                        @if(!is_null($item->tokens_body))
                            <ul>
                                @foreach(explode(",", $item->tokens_body) as $token)
                                    <li>{{ $token }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No available</p>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@stop

@push('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

    <script type="text/javascript">
        $('.email-body').summernote({
            height: 300
        });
    </script>
@endpush

@include('partials.admin.footer')
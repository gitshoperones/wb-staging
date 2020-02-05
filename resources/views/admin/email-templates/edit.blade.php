@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Edit Email Template')
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
                <form method="POST" action="{{ url(sprintf('/admin/email-templates/%s/update', $email_template->id)) }}" accept-charset="UTF-8">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $email_template->name }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" cols="5" rows="15" id="content" name="content">{{ $email_template->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a type="submit" class="btn btn-danger" href="{{ url('admin/email-templates')}}">Cancel</a>
                    </div>
                </form>
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
        $('#content').summernote({
            height: 300
        });
    </script>
@endpush

@include('partials.admin.footer')
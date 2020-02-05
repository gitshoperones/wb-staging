@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Custom Notification')

@section('content_header')
    <h1>Create Custom Notifications</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <form id="create-notification" action="{{ route('notifications.store') }}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="">Sent to User Emails (comma-separated values):</label>
                    <input name="emails" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Or Upload CSV (Please have one column only for the email):</label>
                    <input name="csv_file" type="file" class="form-control-file">
                </div>

                <div class="form-group">
                    <label for="">Title Heading:</label>
                    <input name="title" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Description:</label>
                    <textarea name="body" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="">Button Link:</label>
                            <input name="btnLink" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Button Text:</label>
                            <input name="btnTxt" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">Create</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#create-notification button[type="submit"]').on('click', function(e){
            e.preventDefault();

            var _this = $(this).parents('form');

            swal({
                title: 'Are you sure?',
                text: "Are you sure you are ready to send this notification?",
                type: 'warning',
                width: 600,
                padding: '3em',
                showCancelButton: true,
                cancelButtonText: 'No, keep editing',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send now'
            }).then((result) => {
                if (result.value) {
                    _this.submit();
                }
            });
        });
    </script>
@endpush

@include('partials.admin.footer')
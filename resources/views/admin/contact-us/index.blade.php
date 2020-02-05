@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Contact Us')

@section('content_header')
    <h1>Contact Us Form <a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-contact-us') }}" >Export Contact Us Records</a></h1>
@endsection

@section('content')
    {{-- <div class="container"> --}}
        @include('partials.alert-messages')

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ url('admin/contact-us/') }}" {{ ($filter == null) ? 'disabled' : '' }} class="btn btn-default">All</a>
                    <a href="{{ url('admin/contact-us/open') }}" {{ ($filter == 'open') ? 'disabled' : '' }} class="btn btn-default">Filter By Open</a>
                    <a href="{{ url('admin/contact-us/complete') }}" {{ ($filter == 'complete') ? 'disabled' : '' }} class="btn btn-default">Filter by Complete</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                {{ $contactRecords->links() }}
            </div>
        </div>
        
        <div class="row">
            @foreach ($contactRecords as $record)
            <div class="col-md-8">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <div class="user-block">
                            @if ($record->status != 'Complete')
                                <i class="fa fa-envelope-open text-danger" style="width: 40px; height: 40px; float:left; font-size: 40px;"></i>
                            @else
                                <i class="fa fa-check text-success" style="width: 40px; height: 40px; float:left; font-size: 40px;"></i>
                            @endif

                            <span class="username">
                                {{ $record->details['name'] }} - ({{ $record->email }})<br>{{ $record->details['phone'] }}
                            </span>
                            <span class="description">
                                Sent: {{ $record->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <div class="box-tools">
                            <form class="delete-contact-us" action="{{ route('contact-us.destroy', ['id' => $record->id]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="btn btn-box-tool"><i class="fa fa-trash text-danger"></i></button>
                            </form>
                        </div>
                    </div>
    
                    <div class="box-body">
                        <em><strong>How you heard about us:</strong> {!! $record->details['source'] !!}</em>
                        <br>
                        <em><strong>Reason:</strong> {!! $record->details['reason'] !!}</em>

                        <p style="word-wrap: break-word;">{!! $record->message !!}</p>

                        @if ($record->status == 'Complete')
                            <form id="mark-status" 
                                action="{{ route('contact-us.update', ['id' => $record->id]) }}" 
                                method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                
                                <input type="hidden" name="status" value="1">
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-envelope-open"></i> Mark as Open</button>
                            </form>
                        @else
                            <form id="mark-status" 
                                action="{{ route('contact-us.update', ['id' => $record->id]) }}" 
                                method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                
                                <input type="hidden" name="status" value="2">
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-check"></i> Mark as Complete</button>
                            </form>
                        @endif
                    </div> 
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-8">
                {{ $contactRecords->links() }}
            </div>
        </div>
        
    {{-- </div> --}}
@stop

@push('scripts')
    <script type="text/javascript">
        $('.delete-contact-us button.btn').on('click', function(e){
            e.preventDefault();

            var _this = $(this).parents('form');

            swal({
                title: 'Are you sure?',
                text: "You are about to delete this user!",
                type: 'warning',
                width: 600,
                padding: '3em',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes understood!'
            }).then((result) => {
                if (result.value) {
                    console.log(_this);
                    _this.submit();
                }
            });
        });

        $('#mark-open').on('click', function(e){
            e.preventDefault();

            var status = $(this).data('status');
            var actionUrl = $(this).attr('href');
            var form = $('#delete-fee');

            form.closest('input[name="status"]').value = status;

            console.log(actionUrl);

            form.attr('action', actionUrl);
            // form.submit();
        });
    </script>
    <script type="text/javascript">
        
    </script>
@endpush

@include('partials.admin.footer')
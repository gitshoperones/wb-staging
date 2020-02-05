@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Job Posts')

@section('content_header')
    <h1>Job Quote <a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-job-quotes') }}" >Export Job Quotes</a></h1>
@endsection

@section('content')
    @include('partials.alert-messages')
    {{-- <div class="row">
        <form method="GET" action="{{ url('admin/job-posts') }}" accept-charset="UTF-8">
            <div class="col-lg-5 col-lg-offset-6">
                <input class="pull-right form-control" type="search" name="search" placeholder="Search..">
            </div>
            <div class="col-lg-1"><input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Search" /></div>
        </form>
    </div> --}}
    <table id="dataInfo" class="table display">
        <thead>
            <tr>
                <th>Business Name</th>
                <th>Category</th>
                <th>Event</th>
                <th>Locations</th>
                <th>Event Date</th>
                <th>Quote Amount</th>
                <th>Quote Expiry</th>
                <th>Status</th>
                <th>Couple Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobQuotes as $jobQuote)
                <tr>
                    <td>{{ $jobQuote->user->vendorProfile->business_name }}</td>
                    <td>{{ $jobQuote->jobPost->category->name }}</td>
                    <td>{{ $jobQuote->jobPost->event->name }}</td>
                    <td>{!! $jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}</td>
                    <td>{{ $jobQuote->jobPost->event_date ?: 'unknown' }}</td>
                    <td>{{ number_format($jobQuote->total, 2, ".", ",") }}</td>
                    <td>{{ $jobQuote->duration }}</td>
                    <td>{{ $jobQuote->statusText() }}</td>
                    <td>{{ $jobQuote->jobPost->userProfile->title }}</td>
                    <td>
                        <form class="delete-job-quotes" action="{{ url('admin/job-quotes/' . $jobQuote->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap">
        {{ $jobQuotes->links() }}
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $('.delete-job-quotes button.btn').on('click', function(e){
            e.preventDefault();

            var _this = $(this).parents('form');

            swal({
                title: 'Are you sure?',
                text: "You are about to delete this job quote!",
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
    </script>
@endpush

@include('partials.admin.footer')
@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Pending Job Posts')

@section('content_header')
    <h1>Pending Jobs <a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-job-posts/pending') }}" >Export Pending Jobs</a></h1>
@endsection

@push('css')
<style>
    .btn-group.pending a {
        width: auto;
    }
    @keyframes rotate360 {
        to { transform: rotate(360deg); }
    }
    .fa-refresh { animation: 2s rotate360 infinite linear; }
</style>
@endpush

@section('content')
    @include('partials.alert-messages')
    <div class="row">
        <form method="GET" action="{{ url('admin/pending-job-posts') }}" accept-charset="UTF-8">
            <div class="col-lg-5 col-lg-offset-6">
                <input class="pull-right form-control" type="search" name="search" placeholder="Search..">
            </div>
            <div class="col-lg-1"><input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Search" /></div>
        </form>
    </div>
    <table id="dataInfo" class="table display">
        <thead>
            <tr>
                <th>Couple</th>
                <th>Category</th>
                <th>Event</th>
                <th>Locations</th>
                <th>Event Date</th>
                <th>Created Date</th>
                <th>Job Expiry</th>
                <th>Job Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobPosts as $jobPost)
                <tr>
                    <td>{{ $jobPost->userProfile->title }}</td>
                    <td>{{ $jobPost->category->name }}</td>
                    <td>{{ $jobPost->event->name }}</td>
                    <td>{!! $jobPost->locations->implode('name', ',&nbsp;') !!}</td>
                    <td>{{ $jobPost->event_date ?: 'unknown' }}</td>
                    <td>{{ $jobPost->created_at->format('d/m/Y') }}</td>
                    <td>{{ $jobPost->updated_at->addWeeks(12)->format('d/m/Y') }}</td>
                    <td>
                        @if($jobPost->job_type === 0)
                            Job Posted
                        @elseif($jobPost->job_type === 1)
                            Quote Requested - Single
                        @elseif($jobPost->job_type === 2)
                            Quote Requested - Multiple
                        @endif
                    </td>
                    <td>
                        <div class="btn-group pending" role="group">
                            <a class="btn btn-primary btn-xs"
                                href="{{ url(sprintf('/admin/pending-job-posts/%s', $jobPost->id))}}" title="View Job">
                                <i class="fa fa-search"></i>
                            </a>
                            <button class="btn btn-success btn-xs btn-approve" data-id="{{ $jobPost->id }}" title="Approve Job">
                                <i class="fa fa-check"></i>
                            </button>
                            <button class="btn btn-danger btn-xs btn-destroy" data-id="{{ $jobPost->id }}" title="Delete Job">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap">
        {{ $jobPosts->appends(request()->all())->links() }}
    </div>
@stop

@push('scripts')
<script>
$('.btn-approve').click(function() {
    var jobId = $(this).data('id'),
        row = $(this).parents('tr')

    $(this).find('i').removeClass('fa-check').addClass('fa-refresh')

    $.ajax( {
        type: "PUT",
        data: {
            '_token': '{{ @csrf_token() }}'
        },
        url: '/admin/pending-job-posts/'+jobId,
        success: function() {
            row.fadeOut()
        }
    });

})

$('.btn-destroy').click(function() {
    var jobId = $(this).data('id'),
        row = $(this).parents('tr')

    $(this).find('i').removeClass('fa-trash').addClass('fa-refresh')

    $.ajax( {
        type: "DELETE",
        data: {
            '_token': '{{ @csrf_token() }}'
        },
        url: '/admin/pending-job-posts/'+jobId,
        success: function() {
            row.fadeOut()
        }
    });

})

</script>
@endpush

@include('partials.admin.footer')
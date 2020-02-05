@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Job Posts')

@section('content_header')
    <h1>Live Jobs <a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-job-posts/live') }}" >Export Live Jobs</a></h1>
@endsection

@section('content')
    @include('partials.alert-messages')
    <div class="row">
        <form method="GET" action="{{ url('admin/job-posts') }}" accept-charset="UTF-8">
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
                {{-- <th>Budget</th> --}}
                <th>Event Date</th>
                <th>Created Date</th>
                <th>Job Expiry</th>
                <th>Status</th>
                <th>Job Type</th>
                <th>Total Quotes</th>
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
                    {{-- <td>{{ $jobPost->budget }}</td> --}}
                    <td>{{ $jobPost->event_date ?: 'unknown' }}</td>
                    <td>{{ $jobPost->created_at->format('d/m/Y') }}</td>
                    <td>{{ $jobPost->updated_at->addWeeks(12)->format('d/m/Y') }}</td>
                    <td>
                        @if ($jobPost->status === 0)
                            Draft
                        @elseif ($jobPost->status === 1)
                            Live
                        @else
                            Close
                        @endif
                    </td>
                    <td>
                        @if($jobPost->job_type === 0)
                            Job Posted
                        @elseif($jobPost->job_type === 1)
                            Quote Requested - Single
                        @elseif($jobPost->job_type === 2)
                            Quote Requested - Multiple
                        @endif
                    </td>
                    <td>{{ count($jobPost->quotes) }}</td>
                    <td>
                        <a class="btn btn-default btn-xs"
                            href="{{ url(sprintf('/admin/job-quotes/%s', $jobPost->id))}}">
                            View Quotes
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap">
        {{ $jobPosts->appends(request()->all())->links() }}
    </div>
@stop

@include('partials.admin.footer')
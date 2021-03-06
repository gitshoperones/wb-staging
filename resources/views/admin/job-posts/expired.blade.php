@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Expired Job Posts')

@section('content_header')
    <h1>Expired Jobs <a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-job-posts/expired') }}" >Export Expired Jobs</a></h1>
@endsection

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <div class="row">
            <form method="GET" action="{{ url('admin/expired-jobs') }}" accept-charset="UTF-8">
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
                    <th>Status</th>
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
                        <td>Expired</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@include('partials.admin.footer')
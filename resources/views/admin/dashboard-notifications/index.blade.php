@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Dashboard Notifications')

@section('content')
    @include('partials.alert-messages')
    <div class="container">
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Sent To</th>
                    <th>Trigger</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dashboard_notifications as $dashboard_notification)
                    <tr>
                        <td>{{ $dashboard_notification->subject }}</td>
                        <td>{{ $dashboard_notification->recipient }}</td>
                        <td>{{ $dashboard_notification->notification_event->name  }}</td>
                        <td>
                            <a class="btn btn-info btn-xs" href="{{ url(sprintf('/admin/dashboard-notifications/%s/edit', $dashboard_notification->id)) }}">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@push('scripts')
@endpush

@include('partials.admin.footer')
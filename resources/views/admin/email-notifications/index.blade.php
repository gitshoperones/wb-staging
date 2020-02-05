@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Email Notifications')

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
                @foreach($email_notifications as $email_notification)
                    <tr>
                        <td>{{ $email_notification->subject }}</td>
                        <td>{{ $email_notification->recipient }}</td>
                        <td>{{ $email_notification->notification_event->name }}</td>
                        <td>
                            <a class="btn btn-info btn-xs" href="{{ url(sprintf('/admin/emails/%s/edit', $email_notification->id)) }}">
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
@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Custom Notification')

@section('content_header')
    <h1>Notifications <a href="{{ route('notifications.create') }}" class="btn btn-primary pull-right">Create Custom Notification</a></h1>
@endsection

@section('content')
    @include('partials.alert-messages')
    <div class="">
        <table id="dataInfo" class="table display no-margin table-notification">
            <thead>
                <tr>
                    <th>Sent To</th>
                    <th>Sent Date</th>
                    <th>Contents</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr>
                        <td>
                            {{ optional($notification->notifiable)->email }}
                        </td>
                        <td>
                            {{ $notification->created_at->diffForHumans() }}
                        </td>
                        <td>
                            <div class="name">
                                <strong>{{ $notification->data['title'] }}</strong>
                            </div>
    
                            <div class="desc">
                                {{ $notification->data['body'] }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
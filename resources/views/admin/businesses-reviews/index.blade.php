@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Businesses Reviews')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($businesses as $business)
                    <tr>
                        <td>{{ $business->business_name}}</td>
                        <td>{{ $business->user->email }}</td>
                        <td>
                            @include('partials.profiles.vendor-stars', ['userProfile' => $business, 'hideEmptyStars' => true])
                        </td>
                        <td>
                            <a class="btn btn-success btn-xs"
                                href="{{ url(sprintf('/admin/businesses/%s/reviews', $business->id)) }}">
                                View Reviews
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">
            {{ $businesses->appends(request()->all())->links() }}
        </div>
    </div>
@stop


@include('partials.admin.footer')
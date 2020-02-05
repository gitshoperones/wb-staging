@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Pages')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Page Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>{{ $page->name }}</td>
                        <td>
                            <a class="btn btn-success btn-xs"
                                href="{{ url(sprintf('/admin/pages/%s/page-settings', $page->id)) }}">
                                Settings
                            </a>
                            <br/>
                            <a class="btn btn-info btn-xs"
                                href="{{ url(sprintf('/admin/pages/%s/edit', $page->id)) }}">
                                Edit
                            </a>
                            <br/>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@include('partials.admin.footer')
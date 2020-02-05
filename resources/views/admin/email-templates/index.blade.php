@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Email Templates')

@section('content_header')
    <h1>Automated Notifications</h1>
@endsection

@section('content')
    @include('partials.alert-messages')
    <div class="">
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Template Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($email_templates as $email_template)
                    <tr>
                        <td>{{ $email_template->name }}</td>
                        <td>
                            <a class="btn btn-info btn-xs" href="{{ url(sprintf('/admin/email-templates/%s/edit', $email_template->id)) }}">
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
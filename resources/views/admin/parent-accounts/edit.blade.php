@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Edit Parent Account')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url(sprintf('admin/parent-accounts/%s', $user->id)) }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            @include('partials.alert-messages')
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Business Name</label>
                    <input type="text" class="form-control" name="business_name" value="{{ $user->vendorProfile->business_name ?: old('business_name') }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $user->email ?: old('email') }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Update" />
                </div>
            </div>
        </form>
    </div>
@stop
@include('partials.admin.footer')
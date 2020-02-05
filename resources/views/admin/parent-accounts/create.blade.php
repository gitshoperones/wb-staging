@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Create Parent Account')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('admin/parent-accounts') }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            @include('partials.alert-messages')
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Business Name</label>
                    <input type="text" class="form-control" name="business_name" value="{{ old('business_name') }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Save" />
                </div>
            </div>
        </form>
    </div>
@stop
@include('partials.admin.footer')
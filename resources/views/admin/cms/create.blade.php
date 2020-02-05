@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Create Page')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('admin/pages') }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            @include('partials.alert-messages')
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Page Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Save" />
                </div>
            </div>
        </form>
    </div>
@endsection
@include('partials.admin.footer')
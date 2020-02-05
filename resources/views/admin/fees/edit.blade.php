@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Edit Fee')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('admin/fees/'.$fee->id) }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="patch">
            @include('partials.alert-messages')
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') ?: $fee->name }}" required>
                    <small><i>Unique name of the fee.</i></small>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Percent</label>
                    <input type="text" class="form-control" name="percent" value="{{ old('percent') ?: $fee->amount }}" required>
                    <small><i>The fee percentage that will apply to all payment.</i></small>
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
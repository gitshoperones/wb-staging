@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Create Parent Account')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('admin/database-backup') }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            @include('partials.alert-messages')
            <div class="row">
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Backup Now!" />
                </div>
            </div>
        </form>
    </div>
@stop
@include('partials.admin.footer')
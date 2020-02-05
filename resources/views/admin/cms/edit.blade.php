@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Edit Page')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url(sprintf('admin/pages/%s', $page->id)) }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="page_id" value="{{ $page->id }}">
            @include('partials.alert-messages')
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Page Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $page->name ?: old('name') }}" required>
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
@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Edit Category')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url(sprintf('/admin/categories/%s', $category->id)) }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <input name="id" type="hidden" value="{{ $category->id }}">
            <input name="_method" type="hidden" value="PATCH">
            @include('partials.alert-messages')
            <div class="row">
                <div class="col-lg-1 form-group">
                    <label>Order #</label>
                    <input type="text" class="form-control" name="order" value="{{ old('order') ?: $category->order }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Category Name</label>
                    <input type="text" class="form-control" name="categoryName" value="{{ old('categoryName') ?: $category->name }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Icon Filename</label>
                    <input type="text" placeholder="ex. test-filename.png" class="form-control" name="icon" value="{{ old('icon') ?: $category->icon }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Update"/>
                </div>
            </div>
        </form>
    </div>
@stop
@include('partials.admin.footer')
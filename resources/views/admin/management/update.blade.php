@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')
	<h1 style="color: #FE5945">Update New Account</h1>
@stop

@section('content')
	<div class="container wb-box">
        <form method="POST" action="{{ url('admin/update/'.$user->id) }}" accept-charset="UTF-8">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="fname" value="{{$user->fname}}" placeholder="First Name" required>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lname" value="{{$user->lname}}"  placeholder="Last Name" required>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}"  placeholder="Email" required>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Account Type</label>
                    <select class="form-control" name="account">
                            <option
                            @if($user->account == "admin")
                                selected
                            @endif value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" value="{{$user->phone_number}}"  placeholder="Phone Number" required>
                </div>
            </div>



            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">

                        <input type="submit" class="btn btn-success btn-md yellow-btn"  value="Update" />


                    </div>
                </div>
            </div>


    </div>
@stop

@include('partials.admin.footer')
@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')
	<h1 style="color: #FE5945">Add New Account</h1>
@stop

@section('content')
	<div class="container wb-box">
        @include('partials.alert-messages')
        <form method="POST" action="{{ url('admin/accounts') }}" accept-charset="UTF-8">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="fname" value="" placeholder="First Name" required>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lname" value=""  placeholder="Last Name" required>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value=""  placeholder="Email" required>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Account Type</label>
                    <select class="form-control" name="account">
                            <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-lg-4 form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" value=""  placeholder="Phone Number" required>
                </div>
            </div>



            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">

                        <input type="submit" class="btn btn-success btn-md yellow-btn"  value="Save" />


                    </div>
                </div>
            </div>


    </div>
@stop

@include('partials.admin.footer')
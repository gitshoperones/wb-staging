@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')
	<h1 style="color: #FE5945">{{ucfirst($userDetails->account)}} Type</h1>
@stop

@section('content')
	<div class="container wb-box">
        <form method="POST" action="" accept-charset="UTF-8">
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" value="{{$userDetails->fname}}" placeholder="First Name">
                </div>
                <div class="col-lg-4 form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" value="{{$userDetails->lname}}"  placeholder="Last Name">
                </div>
                <div class="col-lg-4 form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{$userDetails->email}}"  placeholder="Email">
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                <span>Note: Vendor need to verify email address in order to use the system.</span>
                <a class="btn btn-success btn-xs pull-right" href="{!! url('/admin/verify-user/'.$userDetails->id) !!}">Approve status</a>

                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete-{{$userDetails->id}}" >Delete</a>


                <div class="modal modal-danger fade" id="modal-delete-{{$userDetails->id}}" style="display: none;">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Attention!</h4>
                        </div>
                        <div class="modal-body">
                        Username: {{$userDetails->email}}
                        <p>Are you sure you want to delete
                            @if($userDetails->vendorProfile)
                                {{$userDetails->vendorProfile->business_name}}
                            @else
                                {{$userDetails->fname}} {{$userDetails->lname}}
                            @endif?</p>
                        <p>This user will no longer be on the list and you can't revert back the Deleted user</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <a class="btn btn-outline" href="{!! url('/admin/delete-user/'.$userDetails->id.'/'.$userDetails->status) !!}">Confirm Delete</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                </div>
            </div>
        </form>
    </div>
@stop

@include('partials.admin.footer')
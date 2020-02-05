@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')
	<h1 style="color: #FE5945">{{ucfirst($userDetails->account)}} Type</h1>
@stop

@section('content')
	<div class="container wb-box">
        @include('partials.alert-messages')
        <form method="POST" action="{{ url('admin/update-user/'.$userDetails->id) }}" accept-charset="UTF-8">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="fname" value="{{$userDetails->fname}}" placeholder="First Name">
                </div>
                <div class="col-lg-4 form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lname" value="{{$userDetails->lname}}"  placeholder="Last Name">
                </div>
                <div class="col-lg-4 form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{$userDetails->email}}"  placeholder="Email">
                </div>


                <div class="col-lg-4 form-group">
                    <label>News Letter Subscription</label>
                    <br/>
                    <input type="checkbox"

                    value={{$userDetails->id}}
                    @if($userDetails->newsEmail != null)
                    checked
                    @endif

                    class="btn-xs newsletter" data-toggle="toggle"  data-size="small">
                </div>

                <div class="col-lg-4 form-group">
                    <label>Phone Number:</label>
                    <span>
                        {{ $userDetails->phone_number }}
                    </span>
                </div>

                <div class="col-lg-4 form-group">
                    <label>Services Needed:</label>
                    <span>
                        @if(count($categories))
                        @foreach($categories as $category)
                            {{$category->name}},
                        @endforeach
                        @else
                        N/A
                        @endif
                    </span>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">

                        <input type="submit" class="btn btn-success btn-xs yellow-btn"  value="Save" /> |
                        @if($userDetails->status != "archived")
                        <a class="btn btn-danger btn-xs violet-btn" data-toggle="modal" data-target="#modal-deactivate-{{$userDetails->id}}" >Archive</a>
                        @endif
                        @if($userDetails->status == "archived")
                        <a class="btn btn-success btn-xs"  data-toggle="modal" data-target="#modal-app-{{$userDetails->id}}" >Activate</a>
                        @endif
                        <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete-{{$userDetails->id}}" >Delete</a>
                        @if ($userDetails->status === 'pending email verification' || $userDetails->status === 'pending')
                        <a class="btn btn-success btn-xs"  data-toggle="modal" data-target="#modal-activate-user-{{$userDetails->id}}" >Activate</a>
                        @endif


                        <a href="{{ url(sprintf('/impersonation/%s', $userDetails->id)) }}" class="btn btn-xs btn-info">
                            Impersonate
                        </a>

                    </div>
                </div>
            </div>


        @if($fileDetails)
        <div class="row">
            <div class="col-lg-12">

                @foreach($fileDetails as $file)
                <div class="pull-left">
                    Download verifcation file: <a href="{{ $file['meta_filename'] }}" target="_blank" class="btn wb-btn-grey-round-xs">
                        {{ $file['meta_original_filename'] }},
                    </a>
                </div>
                @endforeach

            </div>
        </div>
        @endif
        </form>


        <div class="modal modal-danger fade" id="modal-deactivate-{{$userDetails->id}}" style="display: none;">
            <form method="POST" action="{{ url('admin/deactivate/'.$userDetails->id) }}" accept-charset="UTF-8">
                {{ csrf_field() }}
            <div class="modal-dialog">
            <div class="modal-content">
                <div style="background-color: #373654 !important; border-color:#000 !important;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Attention!</h4>
                </div>
                <div style="background-color: #373654 !important; border-color:#000 !important;" class="modal-body">
                    <div class="row">
                    <div class="col-md-12">
                        <p>Username: {{$userDetails->email}}</p>
                        <p>Are you sure you want to Archive
                        @if($userDetails->vendorProfile)
                            {{$userDetails->vendorProfile->business_name}}
                        @else
                            {{$userDetails->fname}} {{$userDetails->lname}}
                        @endif?</p>
                    </div>
                    <div class="col-md-12">
                        <label>Reason</label>
                        <textarea required class="form-control" rows="4" name="deactivate"></textarea>
                    </div>
                </div>
                </div>

                <div style="background-color: #373654 !important; border-color:#000 !important;" class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-outline pull-right" value="Yes, Archive This Account">
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
        </div>
         <div class="modal modal-success fade" id="modal-activate-user-{{$userDetails->id}}" style="display: none;">
            <div class="modal-dialog">
                <form method="POST" action="{{ url('/admin/activate-couple-account/'.$userDetails->id) }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Attention!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Username: {{$userDetails->email}}</p>
                                <p>Are you sure you want to activate {{$userDetails->fname}} {{$userDetails->lname}}?</p>
                            </div>
                            <div class="col-md-12">
                                <label>Reason</label>
                                <textarea required class="form-control" rows="4" name="approve"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-outline pull-right" value="Approve">
                        <!-- <a class="btn btn-outline" href="{!! url('/admin/verify-user/'.$userDetails->id) !!}">Approve</a>-->
                    </div>
                </div>
                <!-- /.modal-content -->
                </div>
            </form>
        </div>

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
                <a class="btn btn-outline" href="{!! url('/admin/delete-user/'.$userDetails->id.'/c'.$userDetails->status) !!}">Confirm Delete</a>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

            <div class="modal modal-success fade" id="modal-app-{{$userDetails->id}}" style="display: none;">
                    <form method="POST" action="{{ url('admin/approve-couple/'.$userDetails->id) }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Attention!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Username: {{$userDetails->email}}</p>
                                    <p>Are you sure you want to activate
                                    @if($userDetails->vendorProfile)
                                        {{$userDetails->vendorProfile->business_name}}
                                    @else
                                        {{$userDetails->fname}} {{$userDetails->lname}}
                                    @endif?</p>
                                </div>
                                <div class="col-md-12">
                                    <label>Reason</label>
                                    <textarea required class="form-control" rows="4" name="approve"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-outline pull-right" value="Activate">

                        </div>
                    </div>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                    </form>
                </div>
            <div class="row">
            <div class="col-lg-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                    <h3 class="box-title">Notes</h3>
                    </div>
                    <div class="box-header">
                        <textarea id="note-description" name="message" rows="4" placeholder="Type Message ..." class="form-control"></textarea>
                        <span class="input-group-btn">
                            <button value="{{$userDetails->id}}" type="submit" class="btn btn-success note-btn yellow-btn">Save Notes</button>
                        </span>
                    </div>
                    <div class="box-body box-comments">
                      <div class="box-comment">

                        <div id="note-data"></div>

                        @foreach($userDetails->latestNote as $note)
                        <div class="comment-text">
                              <span class="username">
                                {{$note['fname']}} {{$note['lname']}}
                                <span class="text-muted pull-right">{{date("F jS Y",strtotime($note['created_at']))}}</span>
                              </span>
                            {{$note['description']}}
                            <hr/>
                        </div>
                        @endforeach

                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@include('partials.admin.footer')
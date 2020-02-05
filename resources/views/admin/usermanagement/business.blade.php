@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')
    <div class="well container wb-box">
        <div class="row">
            <div class="col-md-6">
                <h1>
                    @if($userDetails->account === "vendor")
                        Venue/Supplier
                    @else
                        {{ucfirst($userDetails->account)}}
                    @endif

                </h1>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <h2  style="color: #FE5945">
                    {{ucfirst($userDetails->status)}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
	<div class="well container wb-box">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            {{session('status')}}
        </div>
        @endif
        @include('partials.alert-messages')

        <form method="POST" action="{{ url('admin/update-user/'.$userDetails->id) }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <input type="hidden" name="dob" id="user-dob">
        <div class="row">
            <div class="col-lg-4 form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="fname" value="{{ucwords($userDetails->fname)}}" placeholder="First Name">
            </div>
            <div class="col-lg-4 form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="lname" value="{{ucwords($userDetails->lname)}}"  placeholder="Last Name">
            </div>
            <div class="col-lg-4 form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{$userDetails->email}}"  placeholder="Email">
            </div>
            <div class="col-lg-2 form-group">
                <label>ABN</label>
                <input type="text" maxlength="11" minlength="11" name="abn" class="form-control"
                @if($userDetails->vendorProfile)
                value="{{$userDetails->vendorProfile->abn}}"
                @endif
                placeholder="ABN Number">
            </div>

            <div class="col-lg-3 form-group">
                <label>Business Name</label>
                <input type="text" name="business_name" class="form-control"
                @if($userDetails->vendorProfile)
                value="{{$userDetails->vendorProfile->business_name}}"
                @endif
                placeholder="Business Name">
            </div>
            <div class="col-lg-3 form-group">
                <label>Website</label>
                <input type="text" name="website" class="form-control"
                @if($userDetails->vendorProfile)
                value="{{$userDetails->vendorProfile->website}}"
                @endif
                placeholder="Website">
            </div>
            <div class="col-lg-4 form-group">
                <div class="form-group">
                    <label class="main"for="">Date of Birth</label>
                    <br/>
                    @php
                        if (old('dobM')) {
                            $dobM = old('dobM');
                        } else {
                            $dobM = $userDetails->dob ? $userDetails->dob->format('m') : '';
                        }
                        if (old('dobD')) {
                            $dobD = old('dobD');
                        } else {
                            $dobD = $userDetails->dob ? $userDetails->dob->format('d') : '';
                        }
                        if (old('dobY')) {
                            $dobY = old('dobY');
                        } else {
                            $dobY = $userDetails->dob ? $userDetails->dob->format('Y') : '';
                        }
                    @endphp
                    <select class="" id="dob-d" name="birth_day" style="padding:5px">
                        <option value="">Day &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </option>
                        @for($i = 1; $i < 32; $i++)
                            <option
                            @if ($dobD == $i)
                                selected
                            @endif
                            value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <select class="" id="dob-m" name="birth_month" style="padding:5px">
                        <option value="">Month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                        @for($i = 1; $i < 13; $i++)
                            <option
                            @if ($dobM == $i)
                                selected
                            @endif
                            value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <select class="" id="dob-y" name="birth_year" style="padding:5px">
                        <option value="">Year &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                        @for($i = now()->subYears(18)->format('Y'); $i >= 1940; $i--)
                            <option
                            @if ($dobY == $i)
                                selected
                            @endif
                            value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-lg-3 form-group">
                <label>Account Manager</label>
                <select name="account_manager" class="form-control">
                    <option value="">Select</option>
                    @foreach($accountManager as $manager)
                        <option
                        @if($userDetails->manager && $manager->id === $userDetails->manager->accnt_mngr_id)
                            selected
                        @endif
                        value={{$manager->id}} >{{$manager->fname}} {{$manager->lname}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 form-group">
                <label>Contact Phone Number</label>
                <input type="text" name="phone_number" class="form-control"
                value="{{$userDetails->phone_number}}"
                placeholder="Contact Phone Number">
            </div>
            <div class="col-lg-2 form-group">
                <label>State</label>
                <select name="state" class="form-control">
                    @foreach($states as $key => $state)
                        @if ($userDetails->vendorProfile && $userDetails->vendorProfile->state === $key)
                            <option value="{{ $key }}" selected>{{ $key }}</option>
                        @else
                            <option value="{{ $key }}">{{ $key }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 form-group">
                <label>Postcode</label>
                <input type="text" name="postcode" class="form-control"
                @if($userDetails->vendorProfile)
                value="{{$userDetails->vendorProfile->postcode}}"
                @endif

                placeholder="Postcode">
            </div>
            <div class="col-lg-2 form-group">
                <label>News Letter Subscription</label>
                <input type="checkbox"

                value={{$userDetails->id}}
                @if($userDetails->newsEmail != null)
                checked
                @endif

                class="btn-xs newsletter" data-toggle="toggle"  data-size="mini">
            </div>
            <div class="col-lg-4 form-group">
                <div class="col-lg-6 form-group">
                    <label>Fee Name</label>
                    <p>{{ $userDetails->vendorProfile->fee->fee ? $userDetails->vendorProfile->fee->fee->name : '--' }}</p>
                </div>
                <div class="col-lg-6 form-group">
                    <label>Fee Percent</label>
                    <p>{{ $userDetails->vendorProfile->fee->fee ? $userDetails->vendorProfile->fee->fee->amount : 0}}%</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                <span class="for1m-control">
                    <div class="form-group">
                        <label>Services:</label>
                        <select class="form-control select2" multiple="multiple" name="expertises[]" data-placeholder="Services"
                                style="width: 100%;">
                                @foreach ($categories as $category)
                                <option value="{{ $category->name }}"
                                    @if((is_array($userProfile->expertise->pluck('name')->toArray()) && (in_array($category->name, $userProfile->expertise->pluck('name')->toArray()))))
                                    selected
                                    @endif>
                                        {{ $category->name }}
                                </option>
                                @endforeach
                        </select>
                        </div>
                    {{-- <div>
                        <dl class="selectdropdown" style="width: 100%;">
                            <dt style="max-width: 600px; margin: auto;">
                            </dt>
                            <dd style="max-width: 400px; margin: auto;">
                                <div class="mutliSelect">
                                    <ul>
                                        @foreach ($categories as $category)
                                            <ul>
                                                <li>
                                                <input class="vendor-service-locations" type="checkbox"
                                                @if((is_array($userProfile->expertise->pluck('name')->toArray()) && (in_array($category->name, $userProfile->expertise->pluck('name')->toArray()))))
                                                checked
                                                @endif
                                                name="expertises[]"
                                                id="cat{{ $category->id }}"
                                                value="{{ $category->name }}" />
                                                <label for="cat{{ $category->id }}">{{ $category->name }}</label>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                    </div> --}}
                </span>
            </div>

            @if(!$locationVendor->isEmpty())
            <div class="col-lg-6 form-group">
                <label>Region: </label>
                <span>
                    @foreach($locationVendor as $lv)
                        {{$lv->name}},
                    @endforeach
                </span>
            </div>
            @endif

        </div>

        <div class="row">
            <div class="col-lg-12">
                <input class="btn btn-xs" action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />


                <div class="pull-right">

                        @if($userDetails->status != "pending delete")
                            <input type="submit" id="submit-user-form" class="btn btn-success btn-xs yellow-btn"  value="Save" />
                        @endif

                        @if($userDetails->status == "pending email verification" || $userDetails->status == "active" || $userDetails->status === "rejected" || $userDetails->status === "archived")
                            <a class="btn btn-success btn-xs gray-btn"  data-toggle="modal" data-target="#modal-app-email-{{$userDetails->id}}" >Move to Pending</a>
                        @endif

                        @if($userDetails->status == "pending")
                            <a class="btn btn-success btn-xs"  data-toggle="modal" data-target="#modal-app-{{$userDetails->id}}" >Approve</a>
                        @endif

                        @if($userDetails->status !== "archived")
                            <a class="btn btn-warning btn-xs"  data-toggle="modal" data-target="#modal-archive-{{$userDetails->id}}" >Archive</a>
                        @endif

                        @if($userDetails->status == "archived")
                            <a class="btn btn-success btn-xs"  data-toggle="modal" data-target="#modal-activate-{{$userDetails->id}}" >Activate</a>
                            <a class="btn btn-danger btn-xs"  data-toggle="modal" data-target="#modal-delete-{{$userDetails->id}}" >Delete</a>
                        @endif

                        <a href="{{ url(sprintf('/impersonation/%s', $userDetails->id)) }}" class="btn btn-xs btn-info">
                            Impersonate
                        </a>
                        <a href="{{ url(sprintf('/admin/fees/vendor/%s', $userDetails->vendorProfile->id)) }}" class="btn btn-xs btn-success">
                            Setup Fees
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
                        @foreach($noteDetails as $note)
                        <div class="comment-text">
                              <span class="username">
                                {{$note['fname']}} {{$note['lname']}},
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
            @include('partials.admin.upload-user-file')
        </div>

        @if($userDetails->status === "pending")
        <div class="row" style="margin-top: 50px;">
            <div class="col-sm-12">
                <table class="table">

                    <tr>
                        <th>1.	Did they provide an ABN?</th>
                    <tr>
                    <tr>
                        <td style="padding-left: 20px;">&#9675; If no, request this, we cannot proceed without a matching ABN</td>
                    <tr>

                    <tr>
                        <th>2.	Does the ABN they provided match their business name, state and postcode?</th>
                    <tr>
                    <tr>
                        <td style="padding-left: 20px;">&#9675; If no, request additional verification documents</td>
                    <tr>



                    <tr>
                        <th>3.	Do they have a website or social media account showing their work, and does this website match the business name & ABN? </th>
                    <tr>
                    <tr>
                        <td style="padding-left: 20px;">&#9675; If no, request these. Without an online portfolio, we cannot proceed. </td>
                    <tr>

                    <tr>
                        <th>4.	Does their past work look professional and up to wedBooker standard?</th>
                    <tr>
                    <tr>
                        <td style="padding-left: 20px;">&#9675; If not, request written references and more examples of work. Do not approve unless they are up to standard.</td>
                    <tr>

                    <tr>
                        <th>5.	Does their sign up email address belong to their website domain? </th>
                    <tr>
                    <tr>
                        <td style="padding-left: 20px;">&#9675; If no, request additional verification documents to be uploaded to the verification tab</td>
                    <tr>



                    <tr>
                        <th>6.	Is there any doubt that they are who they say they are?</th>
                    <tr>
                    <tr>
                        <td style="padding-left: 20px;">&#9675; Call the number listed on the company website and check it is them who is signing up to wedBooker </td>
                    <tr>
                    <tr>
                        <td style="padding-left: 20px;">&#9675; AND request additional verification documents to be uploaded to the verification tab.</td>
                    <tr>

                </table>


            </div>
        </div>
        @endif

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
                </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
            <div class="modal-details">


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

                        <div class="modal modal-danger fade" id="modal-deactivate-{{$userDetails->id}}" style="display: none;">
                            <form method="POST" action="{{ url('admin/deactivate/'.$userDetails->id) }}" accept-charset="UTF-8">
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
                                        <p>Username: {{$userDetails->email}} - {{$userDetails->id}}</p>
                                        <p>Are you sure you want to put in pending delete
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

                                <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-outline pull-right" value="Confirm">
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </form>
                        </div>

                        <div class="modal modal-warning fade" id="modal-danger-{{$userDetails->id}}" style="display: none;">
                            <form method="POST" action="{{ url('admin/deny/'.$userDetails->id) }}" accept-charset="UTF-8">
                            {{ csrf_field() }}
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div style="color: #000 !important;border-color: #ff9c00 !important;" class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Attention!</h4>
                                    </div>
                                    <div style="color: #000 !important;border-color: #ff9c00 !important;" class="modal-body">
                                        <div class="row">
                                        <div class="col-md-12">
                                            <p>Username: {{$userDetails->email}}</p>
                                            <p>Are you sure you want to Reject
                                            @if($userDetails->vendorProfile)
                                                {{$userDetails->vendorProfile->business_name}}
                                            @else
                                                {{$userDetails->fname}} {{$userDetails->lname}}
                                            @endif?</p>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Reason</label>
                                            <textarea required class="form-control" rows="4" name="deny"></textarea>
                                        </div>

                                        </div>
                                    </div>
                                    <div style="color: #000 !important;border-color: #ff9c00 !important;" class="modal-footer">
                                    <button style="color: #000 !important;border-color: #ff9c00 !important; border-color:#fff !important;" type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                    <input style="color: #000 !important;border-color: #ff9c00 !important; border-color:#fff !important;" type="submit" class="btn btn-outline pull-right" value="Confirm Reject">
                                    </div>
                                </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </form>
                        </div>
                        <div class="modal modal-warning fade" id="modal-archive-{{$userDetails->id}}" style="display: none;">
                            <form method="POST" action="{{ url('admin/archive/'.$userDetails->id) }}" accept-charset="UTF-8">
                            {{ csrf_field() }}
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div style="color: #000 !important;border-color: #ff9c00 !important;" class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Attention!</h4>
                                    </div>
                                    <div style="color: #000 !important;border-color: #ff9c00 !important;" class="modal-body">
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
                                            <textarea required class="form-control" rows="4" name="reason"></textarea>
                                        </div>

                                        </div>
                                    </div>
                                    <div style="color: #000 !important;border-color: #ff9c00 !important;" class="modal-footer">
                                    <button style="color: #000 !important;border-color: #ff9c00 !important; border-color:#fff !important;" type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                    <input style="color: #000 !important;border-color: #ff9c00 !important; border-color:#fff !important;" type="submit" class="btn btn-outline pull-right" value="Yes, Archive This Account">
                                    </div>
                                </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </form>
                        </div>

                        <div class="modal modal-success fade" id="modal-app-{{$userDetails->id}}" style="display: none;">
                            <form method="POST" action="{{ url('admin/approve/'.$userDetails->id) }}" accept-charset="UTF-8">
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
                                            <p>Are you sure you want to approve
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
                                    <input type="submit" class="btn btn-outline pull-right" value="Approve">
                                    <!-- <a class="btn btn-outline" href="{!! url('/admin/verify-user/'.$userDetails->id) !!}">Approve</a>-->
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </form>
                        </div>

                        <div class="modal modal-success fade" id="modal-activate-{{$userDetails->id}}" style="display: none;">
                            <form method="POST" action="{{ url('admin/approve/'.$userDetails->id) }}" accept-charset="UTF-8">
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
                                    <input type="submit" class="btn btn-outline pull-right" value="Approve">
                                    <!-- <a class="btn btn-outline" href="{!! url('/admin/verify-user/'.$userDetails->id) !!}">Approve</a>-->
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </form>
                        </div>

                        <div class="modal modal-success fade" id="modal-app-email-{{$userDetails->id}}" style="display: none;">
                            <form method="POST" action="{{ url('admin/approve-email/'.$userDetails->id) }}" accept-charset="UTF-8">
                            {{ csrf_field() }}
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div style="background-color:#999 !important; color:#000 !important;" class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Attention!</h4>
                                </div>
                                <div style="background-color:#999 !important; color:#000 !important;" class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Username: {{$userDetails->email}}</p>
                                            <p>Are you sure you want to move {{ optional($userDetails->vendorProfile)->business_name }} to pending?</p>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Reason</label>
                                            <textarea required class="form-control" rows="4" name="approve"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="background-color:#999 !important; color:#000 !important;" class="modal-footer">
                                    <button style="background-color:#999 !important; color:#000 !important;" type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                    <input style="background-color:#999 !important; color:#000 !important;" type="submit" class="btn btn-outline pull-right" value="Yes, Move To Pending">
                                    <!-- <a class="btn btn-outline" href="{!! url('/admin/verify-user/'.$userDetails->id) !!}">Confirm</a>-->
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </form>
                        </div>
            </div>

    </div>
@stop
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#submit-user-form').on('click', function() {
                var dobD = $('#dob-d').val();
                var dobM = $('#dob-m').val();
                var dobY = $('#dob-y').val();
                var dob = dobY+'-'+dobM+'-'+dobD;
                $('#user-dob').val(dob);
            });
            $('.select2').select2({
                closeOnSelect: false
            })
        })
    </script>
@endpush

@include('partials.admin.footer')
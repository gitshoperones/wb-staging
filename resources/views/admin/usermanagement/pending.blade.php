@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')

<div class="row">
		<div class="col-lg-6">
				<h1>{{ucfirst($type)}} Vendors</h1>
		</div>
		<div class="col-lg-6">
				<a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-users/vendor') }}" >Export Vendor Users</a>
		</div>
	</div>

@stop

@section('content')

<div class="row">
	<form method="POST" action="{{ url('admin/vendors/'.$type) }}" accept-charset="UTF-8">
		{{ csrf_field() }}
		<div class="col-lg-6"></div>
		<div class="col-lg-5">
			<input class="pull-right form-control" type="search" name="search" placeholder="Search..">
		</div>
		<div class="col-lg-1"><input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Search" /></div>
	</form>
</div>

<table id="dataInfo" class="table display">
        <thead>
            <tr>
				<th>Email</th>
				<th>Account Manager</th>
				<th>Business Name</th>
				<th>Created</th>
				<th>Newsletter</th>
				<th>Status</th>
                <th>Category</th>
                <th>Rating</th>
				<th>Last Login</th>
				<th></th>
            </tr>
        </thead>
        <tbody>
				@foreach($userDetails as $user)

					<tr>
						<td><a href="{!! url('/admin/'.$user->account.'/'.$user->id) !!}">{{$user->email}}</a></td>
						<td>{{ $user->manager ? $user->manager->userManager->fname.' '.$user->manager->userManager->lname : '' }}</td>
						</td>
						<td><a href="{!! url('/admin/'.$user->account.'/'.$user->id) !!}">
							@if($user->vendorProfile)
							{{ $user->vendorProfile->business_name}}
							@endif
						</a>
						</td>
						<td>
							<a href="{!! url('/admin/'.$user->account.'/'.$user->id) !!}">{{date('d-m-Y h:i A', strtotime($user->created_at))}}</a>
						</td>
						<td>
							<input type="checkbox"

							value={{$user->id}}
							@if($user->newsEmail != null)
							checked
							@endif

							class="btn-xs newsletter" data-toggle="toggle"  data-size="mini">
						</td>
						<td>{{$user->status}}</td>
						<td>
							{{ $user->vendorProfile->expertise ? $user->vendorProfile->expertise->implode('name', ', ') : '' }}
						</td>
                        <td>
                            @include('partials.profiles.vendor-stars', ['userProfile' => $user->vendorProfile, 'hideEmptyStars' => true])
                        </td>
                        <td>{{ $user->updated_at->diffForHumans()}}</td>
						<td>
							<a class="btn btn-info btn-xs" href="{!! url('/admin/'.$user->account.'/'.$user->id) !!}">View Details</a>
						</td>
					</tr>

				@endforeach
        </tbody>
	</table>
	<div class="row">
		<div class="col-lg-6 info">
				Showing {{ $userDetails->count() }} of {{ $userDetails->total() }} entries
		</div>

		<div class="col-lg-6">
			<div class="pull-right">
				{{ $userDetails->links() }}
			</div>
		</div>

	</div>

@stop

@include('partials.admin.footer')
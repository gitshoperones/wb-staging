@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')

<div class="row">
		<div class="col-lg-6">
				<h1>{{ucfirst($type)}} Couples</h1>
		</div>
		<div class="col-lg-6">
				<a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-users/couple') }}" >Export Couple Users</a>
		</div>
	</div>

@stop

@section('content')

<div class="row">
	<form method="POST" action="{{ url('admin/couple/'.request('type')) }}" accept-charset="UTF-8">
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
			<th>Name</th>
			<th>Email</th>
            @if (isset($accountType) && $accountType === 'couple')
            <th>Partner's Fullname</th>
            @endif
			<th>Type</th>
			<th>News Letter Notification</th>
			<th>Note</th>
            <th>Created</th>
			<th>Last Login</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($userDetails as $user)
		<tr>
			<td><a href="{!! url('/admin/'.$user->account.'/'.$user->id.'/view') !!}">{{$user->fname}} {{$user->lname}}</a></td>
            <td><a href="{!! url('/admin/'.$user->account.'/'.$user->id.'/view') !!}">{{$user->email}}</a></td>
            @if (isset($accountType) && $accountType === 'couple')
            <td>
                {{ $user->coupleA['partner_firstname'] }} {{ $user->coupleA['partner_surname'] }}
            </td>
            @endif
			<td><a href="{!! url('/admin/'.$user->account.'/'.$user->id.'/view') !!}">{{$user->account}}</a></td>

			<td>
				<input type="checkbox"

				value={{$user->id}}
				@if($user->newsEmail != null)
				checked
				@endif

				class="btn-xs newsletter" data-toggle="toggle"  data-size="mini">
			</td>
			<td>
				@if($user->latestNote)
				@foreach($user->latestNote as $note)

				<a data-toggle="modal" data-target="#modal-desc-{{$user->id}}" >{{substr($note->description, 0, 30)}}..</a>

					<div class="modal modal-primary fade" id="modal-desc-{{$user->id}}" style="display: none;">
						<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span></button>
							<h4 class="modal-title">{{$user->email}}</h4>
							</div>
							<div class="modal-body">
								{{$note->description}}
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
							</div>
						</div>
						</div>
					</div>
					@php break; @endphp

				@endforeach
				@endif
			</td>
			<td><a href="{!! url('/admin/'.$user->account.'/'.$user->id.'/view') !!}">{{date('d-m-Y h:i A', strtotime($user->created_at))}}</a></td>
            <td>{{ $user->updated_at->diffForHumans() }}</td>
			<td>
				<a class="btn btn-info btn-xs" href="{!! url('/admin/'.$user->account.'/'.$user->id.'/view') !!}">View Details</a>
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
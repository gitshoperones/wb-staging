@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Users')

@section('content_header')

<div class="row">
		<div class="col-lg-6">
				<h1>Admin and Managers</h1>
		</div>
	</div>

@stop

@section('content')

<div class="row">
	<div class="col-lg-12">
			<a class="pull-right btn btn-xs pull-right btn-success" href="{!! url('/admin/accounts/create') !!}">Add New Account</a>
	</div>
</div>
@include('partials.alert-messages')
<table id="dataInfo" class="table display">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Type</th>
			<th>Created</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($userDetails as $user)
		<tr>
			<td><a href="{!! url('/admin/update/'.$user->id) !!}">{{$user->fname}} {{$user->lname}}</a></td>
			<td><a href="{!! url('/admin/update/'.$user->id) !!}">{{$user->email}}</a></td>
			<td><a href="{!! url('/admin/update/'.$user->id) !!}">{{$user->account}}</a></td>
			<td><a href="{!! url('/admin/update/'.$user->id) !!}">{{date('d-m-Y h:i A', strtotime($user->created_at))}}</a></td>
			<td>
				<a class="btn btn-info btn-xs" href="{!! url('/admin/update/'.$user->id) !!}">View Details</a>
                @if ($user->id !== 1 && $user->id !== Auth::id())
                    <a class="btn btn-danger btn-delete-user btn-xs"
                        href="{{ url(sprintf('/admin/accounts/%s', $user->id)) }}">
                        Delete
                    </a>
                @endif
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
    <form action="" id="delete-user-form" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="delete">
    </form>

@stop

@push('scripts')
    <script type="text/javascript">
        $('.btn-delete-user').on('click', function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: "You are about to delete this user!",
                type: 'warning',
                width: 600,
                padding: '3em',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes understood!'
            }).then((result) => {
                if (result.value) {
                    var form = $('#delete-user-form');
                    form.attr('action', link);
                    form.submit();
                }
            });
        });
    </script>
@endpush


@include('partials.admin.footer')
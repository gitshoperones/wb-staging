@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	{{-- @include('partials.job-posts.search-form', [
	'action' => url('dashboard/job-posts/live'),
	'hideLocationSearch' => true
	]) --}}
	<div class="row">
		<div class="col-md-12">
			@include('partials.alert-messages')
		</div>
		<br />
		@foreach($jobPosts as $jobPost)
		<div class="col-md-12">
			<div class="wb-live-job-box" style="position:relative">
				@include('partials.job-posts.job-owner-avatar', ['avatar' => $loggedInUserProfile->profile_avatar])
				<div class="right">
					<div class="header">
						<a class="btn wb-btn-outline-primary display-quotes"
						data-jobpostid="{{ $jobPost->id }}"
						data-toggle="modal"
						data-target="#wb-modal-quotes-received">
						{{ count($jobPost->quotes) }} QUOTES RECEIVED
					</a>
					<h3>
						<a href="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id)) }}">
							{{ $loggedInUserProfile->title }} |
							{{ $jobPost->category->name }} |
							{!! $jobPost->locations->implode('name', ',&nbsp;') !!}
						</a>
					</h3>
				</div>
				@include('partials.job-posts.single-job-sub-header', ['jobPost' => $jobPost])
				
				@if ($jobPost->specifics)
				<div class="description"> {!! $jobPost->specifics !!}</div>
				@endif

				@if($jobPost->vendor_id)
					@if($jobPost->vendor_name($jobPost->vendor_id))
						<div class="description"> Quote requested from {{ $jobPost->vendor_name($jobPost->vendor_id) }} {{ ($jobPost->is_invite) ? 'and other well-matched businesses' : "" }} </div>
					@endif
				@else
					<div class="description"> Quote requested from all well-matched businesses</div>
				@endif

				<div class="footer">
					<!-- <a href="#" class="btn wb-btn-outline-danger">SEND TO MORE SUPPLIERS</a> -->
					<a href="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id)) }}" class="btn wb-btn-outline-primary">VIEW</a>
					@if ($jobPost->status === 1 || $jobPost->status === 5)
					<!-- <a href="#" class="btn wb-btn-outline-danger">SEND TO MORE SUPPLIERS</a> -->
					<a href="{{ url(sprintf('/dashboard/job-posts/%s/edit', $jobPost->id)) }}" class="btn wb-btn-outline-primary">EDIT</a>
					@else
					<a href="{{ url(sprintf('/dashboard/job-posts/%s/edit', $jobPost->id)) }}" class="btn wb-btn-outline-danger">
						Finish Job Listing
					</a>
					@endif
				</div>
			</div>
			<a href="#"
				data-id="{{ $jobPost->id }}"
				data-status="{{ $jobPost->status }}"
				data-toggle="modal"
				data-target="#delete-job-post-modal"
				class="delete-job btn-rounded btn-orange inline-block pos-abs pos-top-right">
			<i class="fa fa-close"></i>
		</a>
	</div>
</div>
@endforeach
@if(count($jobPosts) > 0)
<div class="wb-pagination-block">
	{{ $jobPosts->appends([ 'q' => request('q') ])->links() }}
</div>
@else
<div class="text-center">
	<h3>You have no {{ request('status') }} jobs</h3>
</div>
@endif
</div>
</section>
<div id="delete-job-post-modal" class="wb-modal-quotes-received modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content text-center">
			<div class="modal-header">
				<h4>Are you sure you want to delete this job?</h4>
			</div>
			<form action="" id="delete-job-post-form" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="_method" value="delete">
				<div class="modal-body ">
					<p>Businesses won't be able to quote on this job anymore.</p>
				</div>
				<div class="form-group">
					<button type="submit" class="btn wb-btn-orange">Delete Job</button>
					<button data-dismiss="modal" class="btn wb-btn-primary">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	window.wbQuotes = {list: []};
</script>
@include('modals.quotes-received')
@endsection
@push('scripts')
<script type="text/javascript">
	$('.display-quotes').on('click', function(){
		var jobId = $(this).data('jobpostid');
		window.wbQuotes.list = [];
		NProgress.start();
		$.ajax( {
			type: "GET",
			url: '/dashboard/job-posts/'+jobId+'/quotes',
			success: function( response ) {
				window.wbQuotes.list = response;
				NProgress.done();
			}
		});
	});

	$('.delete-job').on('click', function(e){
		var feeId = $(this).data('id');
		$('#delete-job-post-form').attr('action', '/dashboard/job-posts/' + feeId);
	});
</script>
@endpush

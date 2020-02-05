@extends('layouts.dashboard')

@section('content')
	<section class="content dashboard-container">
		@if(session()->has('modal_message'))
			@include('modals.success-modal', [
				'header' => 'JOB POST',
				'message' => session('modal_message'),
			])
		@endif
		{{-- @include('partials.job-posts.search-form', [
			'action' => url('dashboard/job-posts/draft'),
			'hideLocationSearch' => true
		]) <br /> --}}
		<div class="row">
			@foreach($jobPosts as $jobPost)
				<div class="col-md-12">
					<div class="wb-live-job-box" style="position:relative">
						@include('partials.job-posts.job-owner-avatar', ['avatar' => $loggedInUserProfile->profile_avatar])
						<div class="right">
							<div class="header">
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
							<div class="footer">
								<a href="{{ url(sprintf('/dashboard/job-posts/%s/edit', $jobPost->id)) }}" class="btn wb-btn-outline-danger">
									Finish Job Listing
								</a>
							</div>
						</div>
						<a href="#" class="delete-job btn-rounded btn-orange inline-block pos-abs pos-top-right">
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
					<h3>No draft jobs found.</h3>
				</div>
			@endif
		</div>
	</section>
@endsection

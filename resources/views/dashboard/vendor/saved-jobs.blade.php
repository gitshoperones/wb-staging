@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
    @include('partials.job-posts.search-form', ['action' => url('/dashboard/saved-jobs')])
	<div class="row">
		@if(count($savedJobs) > 0)
		@foreach($savedJobs as $job)
		<div class="col-md-12">
			<div class="wb-saved-job-box s" style="position:relative">
				<div class="preview-img">
					<img id="profile-avatar-preview"
					@if ($job->jobPost->userProfile && $job->jobPost->userProfile->profile_avatar)
					   src=" {{ $job->jobPost->userProfile->profile_avatar }}"
					@else
					   src=" {{ asset('/assets/images/couple-placeholder.jpg') }}"
					@endif
					class="img-square">
				</div>
				<div class="right">
					<div class="header">
						<h3>
							<a href="{{ url(sprintf('/dashboard/job-posts/%s', $job->jobPost->id)) }}">
								{{ $job->jobPost->userProfile->title }} | {{ $job->jobPost->category->name }} | {!! $job->jobPost->locations->implode('name', ',&nbsp;') !!}
							</a>
						</h3>
					</div>
					<div class="sub-header">
						<ul class="list-inline">
							@if ($job->jobPost->event->name)
							<li>
								<span class="icon"><i class="fa fa-star-o"></i></span>
								{{ $job->jobPost->event->name }}
							</li>
							@endif
							<li>
								<span class="icon"><i class="fa fa-calendar"></i></span>
								{{ $job->jobPost->event_date ?: 'unknown' }}
							</li>
							@if ($job->jobPost->required_address)
								<li>
									<span class="icon"><i class="fa fa-map-marker"></i></span>
									{{ $job->jobPost->required_address }}
								</li>
								@endif
								@if ($job->jobPost->number_of_guests)
								<li>
									<span class="icon"><i class="fa fa-user"></i></span>
									{{ $job->jobPost->number_of_guests }}
								</li>
								@endif
								@if (count($job->jobPost->propertyTypes) > 0)
								<li>
									<span class="icon"><i class="fa fa-home"></i></span>
									{{ $job->jobPost->propertyTypes->implode('name', ', ') }}
								</li>
								@endif
						</ul>
					</div>
					@if ($job->jobPost->specifics)
					<div class="description"> {!! $job->jobPost->specifics !!}</div>
					@endif
					<div class="footer">
						@if (in_array($job->jobPost->id, $vendorLiveQuotes))
                            <button
                                disabled
                                class="btn wb-btn-sm btn-default"
                                >
                                QUOTE SUBMITTED
                            </button>
						@elseif (in_array($job->jobPost->id, $vendorDraftQuotes))
							@if($job->jobPost->status !== 1)
							<a href="#"
                                class="btn wb-btn-outline-danger disabled"
                                >
                                JOB EXPIRED
							</a>
							@else
                            <a href="{{ url(sprintf('dashboard/job-quotes/12/edit', array_search($job->jobPost->id, $vendorDraftQuotes))) }}"
                                class="btn wb-btn-outline-danger"
                                >
                                Finish Quote
							</a>
							@endif
						@else
							@if($job->jobPost->status !== 1)
							<a href="#"
                                class="btn wb-btn-outline-danger disabled"
                                >
                                JOB EXPIRED
							</a>
							@else
                            <a href="{{ url(sprintf('/dashboard/job-quotes/create?job_post_id=%s', $job->jobPost->id)) }}"
                                class="btn wb-btn-outline-danger"
                                >
                                QUOTE ON JOB
							</a>
							@endif
                        @endif
					<saved-job job-id="{{ $job->job_post_id }}" saved="true"></saved-job>
					<!-- <button type="button" class="btn btn-default pull-right">SHARE THIS JOB</button> -->
				</div>
			</div>
		</div>
	</div>
	@endforeach
	<div class="wb-pagination-block">
		{{ $savedJobs->appends([
			'keyword' => request('keyword'),
		])->links()
	}}
</div>
@else
<div class="text-center">
	<h3>No saved jobs found.</h3>
</div>
@endif
</div>
</section>
@endsection
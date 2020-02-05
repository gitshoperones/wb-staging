@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-containe findwork">
	@include('partials.job-posts.search-form', ['action' => url('/dashboard/job-posts')])
	<br />
	<div class="row">
		@if(count($jobPosts) > 0)
			@foreach($jobPosts as $jobPost)
				@if($jobPost->vendor_id == null || ($jobPost->vendor_id == auth()->user()->vendorProfile->id) || ($jobPost->vendor_id != auth()->user()->vendorProfile->id && $jobPost->is_invite))
					<div class="col-md-12">
						<div class="wb-saved-job-box" style="position:relative">
							<div class="preview-img">
								<a href="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id)) }}">
									<img id="profile-avatar-preview"
										@if ($jobPost->userProfile && $jobPost->userProfile->profile_avatar)
											src=" {{ $jobPost->userProfile->profile_avatar }}"
										@else
											src="{{ asset('/assets/images/couple-placeholder.jpg') }}"
										@endif
									class="img-square">
								</a>
							</div>
							<div class="right">
								<div class="header">
									<h3>
										<a href="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id)) }}">
											{{ $jobPost->userProfile->title }} |
											{{ $jobPost->category->name }} |
											{!! $jobPost->locations->implode('name', ',&nbsp;') !!}
										</a>

										<div class="pull-right date-wrapper">
											<span class="date-posted text-normal">
												Date Posted:
												<span class="posted">
													{{ $jobPost->created_at->diffForHumans() }}
												</span>
											</span><!-- /.date-posted -->
											{{-- <span class="hide-job"> <i class="fa fa-close"></i> </span> --}}
										</div><!-- /.pull-right -->
									</h3>
								</div>
								<div class="sub-header">
									<ul class="list-inline">
										@if ($jobPost->event->name)
										<li>
											<span class="icon"><i class="fa fa-star-o"></i></span>
											{{ $jobPost->event->name }}
										</li>
										@endif
										<li>
											<span class="icon"><i class="fa fa-calendar"></i></span>
											{{ $jobPost->event_date ?: 'unknown' }}
											@if ($jobPost->is_flexible)
											(this date is flexible)
											@endif
										</li>
										@if ($jobPost->required_address)
										<li>
											<span class="icon"><i class="fa fa-map-marker"></i></span>
											{{ $jobPost->required_address }}
										</li>
										@endif
										@if ($jobPost->number_of_guests)
										<li>
											<span class="icon"><i class="fa fa-user"></i></span>
											{{ $jobPost->number_of_guests }}
										</li>
										@endif
										@if (count($jobPost->propertyTypes) > 0)
										<li>
											<span class="icon"><i class="fa fa-home"></i></span>
											{{ $jobPost->propertyTypes->implode('name', ', ') }}
										</li>
										@endif
									</ul>
								</div>
								@if ($jobPost->specifics)
								<div class="description"> {!! $jobPost->specifics !!}</div>
								@endif
							<div class="footer">
									<a href="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id)) }}" class="btn wb-btn-outline-danger">VIEW JOB</a>
									@if (in_array($jobPost->id, $vendorLiveQuotes))
										<a href="#" class="disabled btn wb-btn-outline-danger">
											QUOTE SUBMITTED
										</a>
									@elseif (in_array($jobPost->id, $vendorDraftQuotes))
										<a href="{{ url(sprintf('dashboard/job-quotes/%s/edit', array_search($jobPost->id, $vendorDraftQuotes))) }}"
											class="btn wb-btn-outline-danger"
											>
											FINISH QUOTE
										</a>
									@else
										<a href="{{ url(sprintf('/dashboard/job-quotes/create?job_post_id=%s', $jobPost->id)) }}"
											class="btn wb-btn-outline-danger"
											>
											QUOTE ON JOB
										</a>
									@endif
									{{-- @if ($jobPost->category->name === 'Venues') --}}
										<span class="tooltip-holder">
											<a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s', $jobPost->user_id)) }}"
												class="btn wb-btn-outline-danger">
												MESSAGE COUPLE <i class="fa fa-info-circle"></i>
											</a>
											<div class="tooltip-alt" style="padding: 10px;">
												If you need more details from the couple before you can provide an accurate quote, you can message them to ask some questions before submitting your quote.
											</div>
										</span>
									{{-- @endif --}}
									<saved-job job-id="{{ $jobPost->id }}" saved="{{ in_array($jobPost->id, $savedJobs) }}"></saved-job>
									{{-- <button type="button" class="btn btn-default pull-right">SHARE THIS JOB</button> --}}
								</div>
							</div>
						</div>
					</div>
				@endif
			@endforeach
			<div class="wb-pagination-block">
				{{ $jobPosts->appends([
					'category' => request('job_category'),
					'locations' => request('locations'),
					])->links()
				}}
			</div>
		@else
			<div class="text-center">
				<h3>No jobs available</h3>
			</div>
		@endif
	</div>
</section>
@endsection

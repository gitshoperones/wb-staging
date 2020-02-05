@extends('layouts.dashboard')

@section('content')
	<div class="wb-small-banner"></div>
	<section id="wb-job-list" class="wb-bg-grey" style="padding: 40px 0px">
		<div class="container-fluid">
			<div class="text-center">
				<h1 class="wb-title">Currently Available Work</h1>
			</div>
			@include('partials.job-posts.search-form')
			@if ($jobPosts)
				@foreach($jobPosts as $jobPost)
					<div class="wb-box-job-list" style="position:relative">
						<div class="" style="position: absolute; top: 50%; transform: translateY(-50%)">
							<img
							@if ($jobPost->userProfile && $jobPost->userProfile->profile_avatar)
								src=" {{ $jobPost->userProfile->profile_avatar }}"
							@else
								src="{{ asset('/assets/images/couple-placeholder.jpg') }}"
							@endif
							class="img-square" style="width: 135px;">
						</div>
						<div class="right">
							<div class="header">
								<h3>
									<a href="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id))}}">
										{{ $jobPost->userProfile->title }} | {{ $jobPost->category->name }} | {!! $jobPost->locations->implode('name', ',&nbsp;') !!}
									</a>
								</h3>
							</div>
							<div class="sub-header">
								<ul class="list-inline">
									<li>
										<span class="icon"><i class="fa fa-clock-o"></i></span>
										{{ $jobPost->event_date }}
									</li>
									<li>
										<span class="icon"><i class="fa fa-folder-o"></i></span>
										{{ $jobPost->category->name }}
									</li>
									@if ($jobPost->category->template === 1 || $jobPost->category->template === 2)
										<li>
											<span class="icon"><i class="fa fa-map-marker"></i></span>
											{!! $jobPost->locations->implode('name', ',&nbsp;') !!}
										</li>
									@endif
									@if ($jobPost->budget)
										<li>
											<span class="icon"><i class="fa fa-usd"></i></span>
											{{ $jobPost->budget }}
										</li>
									@endif
								</ul>
							</div>
							<div class="footer">
								@if (in_array($jobPost->id, $vendorLiveQuotes))
                                    <button
                                        disabled
                                        class="btn wb-btn-sm btn-default"
                                        >
                                        QUOTE SUBMITTED
                                    </button>
                                @elseif (in_array($jobPost->id, $vendorDraftQuotes))
                                    <a href="{{ url(sprintf('dashboard/job-quotes/12/edit', array_search($jobPost->id, $vendorDraftQuotes))) }}"
                                        class="btn wb-btn-outline-danger"
                                        >
                                        Finish Quote
                                    </a>
                                @else
                                    <a href="{{ url(sprintf('/dashboard/job-quotes/create?job_post_id=%s', $jobPost->id)) }}"
                                        class="btn wb-btn-outline-danger"
                                        >
                                        QUOTE ON JOB
                                    </a>
                                @endif
								@auth
									<saved-job job-id="{{ $jobPost->id }}" saved="{{ in_array($jobPost->id, $savedJobs) }}"></saved-job>
								@endauth
								<!-- <button type="button" class="btn btn-default pull-right">SHARE THIS JOB</button> -->
							</div>
						</div>
					</div>
				@endforeach
				<div class="wb-pagination-block">
					{{ $jobPosts->appends(request()->all())->links()
					}}
				</div>
			@else
				<div class="text-center">
					<h1>No Jobs Available</h1>
				</div>
			@endif
		</div>
	</section>
	@guest
		<section class="wb-block danger-bg">
			<h1 class="text" style="margin-bottom: 30px">Get started with WedBooker today</h1>
			<a href="{{ url('/sign-up') }}" class="btn btn-lg btn-danger">BECOME A SUPPLIER</a>
		</section>
	@endguest
@endsection

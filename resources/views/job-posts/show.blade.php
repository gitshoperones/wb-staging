@extends('layouts.dashboard')

@section('content')
	@if(session()->has('modal_message'))
		@include('modals.success-modal', [
    		'header' => 'Thanks for submitting your job',
    		'message' => session('modal_message'),
    		'btnLabel' => 'My Planning Dashboard',
    		'btnUrl' => url('/dashboard')
		])
	@endif
	<section class="wb-bg-grey content">
		<div class="container-fluid">
			<div class="wb-box-job-page">
				@can('edit-job-post', $jobPost)
					<a href="{{ url(sprintf('/dashboard/job-posts/%s/edit', $jobPost->id)) }}" class="edit btn wb-btn-primary">Edit</a>
				@endcan
				<div class="left">
					<img class="profile-img img-square" style="max-width: 100%"
						@if ($jobPost->userProfile->profile_avatar)
						   src=" {{ $jobPost->userProfile->profile_avatar }}"
						@else
						   src="{{ asset('/assets/images/couple-placeholder.jpg') }}"
						@endif
					   >
                    @vendor
                        @if (in_array($jobPost->id, $vendorLiveQuotes))
                            <button
                                disabled
                                class="btn wb-btn-sm btn-default"
                                >
                                QUOTE SUBMITTED
                            </button>
                        @elseif (in_array($jobPost->id, $vendorDraftQuotes))
                            <a href="{{ url(sprintf('dashboard/job-quotes/%s/edit', array_search($jobPost->id, $vendorDraftQuotes))) }}"
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
                        {{-- @if ($jobPost->category->name === 'Venues') --}}
                            <p></p>
                            <a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s', $jobPost->user_id)) }}"
                                class="btn wb-btn-outline-danger"
                                >
                                MESSAGE COUPLE
                            </a>
                        {{-- @endif --}}
                        <div class="p-t-xs">
                            <saved-job job-id="{{ $jobPost->id }}" saved="{{ $isSaved }}"></saved-job>
                        </div>
                    @endvendor
					<!-- <a class="btn wb-btn-xs wb-btn-outline-black">SHARE THIS JOB</a> -->
				</div>
				<div class="right">
					<div class="header">
						<h3>
							{{ $jobPost->userProfile->title }} | {{ $jobPost->category->name }} | {!! $jobPost->locations->implode('name', ',&nbsp;') !!}</h3>
						</div>
						<div class="sub-header">
							<ul class="list-inline">
                                @if ($jobPost->event->name)
                                <li>
                                    <small><b>Event Type:</b></small> <br />
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    {{ $jobPost->event->name }}
                                </li>
                                @endif
								<li>
									<small><b>Date Required:</b></small> <br />
									<span class="icon"><i class="fa fa-calendar"></i></span>
									{{ $jobPost->event_date ?: 'Not set' }}
									@if ($jobPost->is_flexible)
									(this date is flexible)
									@endif
								</li>
								{{-- @if ($jobPost->budget)
								<li>
									<small><b>Max Budget:</b></small> <br />
									<span class="icon"><i class="fa fa-usd"></i></span>
									{{ $jobPost->budget }}
								</li>
								@endif --}}
							</ul>
						</div>
						@if (($jobPost->number_of_guests > 0 && isset($types['approx'])) || ($jobPost->number_of_guests > 0 && isset($types['hasTemplate'])))
							<div class="specification">
								<h1>Approximate Number of Guests:</h1>
								{{ $jobPost->number_of_guests }}
							</div>
						@endif
						@if ($jobPost->required_address && isset($types['address']))
							<div class="specification">
								<h1>{{ $types['address'] }}:</h1>
								{{ $jobPost->required_address }}
							</div>
						@endif
						@if($jobPost->fields && !empty($jobPost->fields))
							@foreach(json_decode($jobPost->fields) as $field)
								@if(isset($field->val))
								<div class="specification">
									<h1>{{ isset($field->title) ? $field->title : "" }}:</h1>
										@if(isset($field->type) && $field->type == 'custom_multi')
										<ul>
											@foreach ($field->val as $option)
											<li>{{ $option }}</li>
											@endforeach
										</ul>
										@else
										{{ (isset($field->type) && $field->type == 'currency') ? '$': '' }}{{ $field->val }}
										@endif
									</div>
								@endif
							@endforeach
						@endif
						@if (count($jobPost->propertyTypes) > 0 && isset($types['property']))
							<div class="specification">
								<h1>{{ $types['property'] }}:</h1>
								<ul>
									@foreach ($jobPost->propertyTypes as $item)
									<li>{{ $item->name }}</li>
									@endforeach
								</ul>
							</div>
						@endif
                        @if ($jobPost->beauty_subcategories_id)
                            <div class="specification">
                                <h1>Looking for...</h1>
                                <p>{{ $jobPost->beautySubcategory->name ?: '' }}</p>
                            </div>
                        @endif
                        @if (count($jobPost->websiteRequirements) > 0 && isset($types['website']))
                            <div class="specification">
                                <h1>{{ $types['website'] }}:</h1>
                                <ul>
                                    @foreach ($jobPost->websiteRequirements as $item)
                                    <li>{{ $item->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($jobPost->completion_date)
                            <div class="specification">
                                <h1>Completion Date:</h1>
                                <p>{{ $jobPost->completion_date }}</p>
                            </div>
                        @endif
						@if (count($jobPost->propertyFeatures) > 0 && isset($types['other']))
							<div class="specification">
								<h1>{{ $types['other'] }}:</h1>
								<ul>
									@foreach ($jobPost->propertyFeatures as $item)
									<li>{{ $item->name }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						@if ($jobPost->timeRequirement && isset($types['time']))
							<div class="specification">
								<h1>{{ $types['time'] }}:</h1>
								{{ $jobPost->timeRequirement->name }}
							</div>
						@endif
						@if ($jobPost->shipping_address)
							<div class="specification">
								<h1>Shipping Address:</h1>
                                @if ($jobPost->status == 2)
								<p>Street: {{ $jobPost->shipping_address['street'] }}</p>
								<p>Suburb: {{ $jobPost->shipping_address['suburb'] }}</p>
                                @endif
								<p>State: {{ $jobPost->shipping_address['state'] }}</p>
								<p>Post Code: {{ $jobPost->shipping_address['post_code'] }}</p>
							</div>
						@endif
						@if ($jobPost->specifics)
                            <div class="specification">
                                <h1>Additional details:</h1>
                                {!! $jobPost->specifics !!}
                            </div>
                        @endif

						@if (!$gallery->isEmpty())
						<div class="wb-gallery">
                            <div class="specification">
                                <h1>Photo Inspiration from {{  $jobPost->userProfile->title }}</h1>
                            </div>
							<div class="carousel slide media-carousel" id="media">
								<div class="carousel-inner">
                                    <div class="grid" id="image-wrapper">
                                        @foreach($gallery as $photo)
                                            <div class="grid-item">
                                                <img src="{{ $photo->getFileUrl() }}"
                                                    class="img-responsive" alt="no image">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
	</section>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/masonry/imagesloaded.pkgd.js') }}"></script>
<script src="{{ asset('assets/js/masonry/packery.pkgd.min.js') }}"></script>
<script>
    $('#image-wrapper').imagesLoaded().done(function(){
        window.$grid = $('#image-wrapper').packery();
    })
</script>
@endpush
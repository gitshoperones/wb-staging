 <div class="col-md-5">
	<div class="wb-send-quote" >
		<div class="wb-box job-details" style="margin-top: 43px; padding: 35px;">
			<div class="header">
				<span style="">JOB DETAILS</span>
			</div>
			<div class=" WA', 'state' => 'Western Australia'],">
				<div class="title">
					@if ($jobPost->userProfile->profile_avatar)
                        <img src="{{ $jobPost->userProfile->profile_avatar }}" alt="" class="img-square">
                    @else
                        <img src="{{ asset('/assets/images/couple-placeholder.jpg') }}" alt="" class="img-square">
                    @endif
					<h3 style="font-family: Josefin Slab; text-transform: uppercase; color: #373654;">{{ $jobPost->userProfile->title }} | {{ $jobPost->category->name }} | {!! $jobPost->locations->implode('name', ',&nbsp;') !!}</h3>
				</div>
				<div class="item">
					<p>
						<label for="">Job Description:</label> <br>
						{!! $jobPost->specifics !!}
					</p>
				</div>
				<div class="item">
					<label for="">Event Type:</label> <span class="value">{{ $jobPost->event->name }}</span>
				</div>

				<div class="item">
					<label for="">Event Date:</label> <span class="value">{{ $jobPost->event_date }} 
					@if ($jobPost->is_flexible)
					(this date is flexible)
					@endif
					</span>
				</div>

				<div class="item">
					<label for="">Venue or Address:</label> <span class="value">{{ $jobPost->required_address }}</span>
				</div>

				<div class="item">
					<label for="">Number of Guests:</label> <span class="value">{{ $jobPost->number_of_guests }}</span>
				</div>

				<div class="item">
					<label for="">Max Budget:</label> <span class="value">${{ $jobPost->budget }}</span>
				</div>

				<div class="item">
					<label for="">Time Required:</label>
                    <span class="value">
                        {{ $jobPost->timeRequirement ? $jobPost->timeRequirement->name : ''  }}
                    </span>
				</div>

				<div class="text-right p-t-sm">
					<a href="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id)) }}" target="_blank" class="btn wb-btn-outline-black-sm">VIEW FULL JOB</a>
				</div>
			</div>
		</div>
	</div>
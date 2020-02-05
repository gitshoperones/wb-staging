<div class="row adv-search fade">
	<div class="col-md-2">
		<div class="form-group">
			<label for="owner_name">Budget</label>
			<div class="input-bordered">
			 <input type="text" class="form-control" name="budget" value="{{ request('budget') }}">
			</div><!-- /.checkbox -->
		</div>
	</div><!-- /.col-md-6 -->
	<div class="col-md-2">
		<div class="form-group">
			<label for="owner_name">Event Date From</label>
			<div class="input-bordered">
			<input id="jobDate"
			onkeydown="return false"
			type="text"
			name="event_date_from"
			value="{{ request('event_date_from') }}"
			data-date-format="MM dd, yyyy"
			class="form-control wb-datepicker">
			</div><!-- /.checkbox -->
		</div>
	</div><!-- /.col-md-6 -->
	<div class="col-md-2">
		<div class="form-group">
			<label for="owner_name">Event Date To</label>
			<div class="input-bordered">
			<input id="jobDate"
			onkeydown="return false"
			type="text"
			name="event_date_to"
			value="{{ request('event_date_to') }}"
			data-date-format="MM dd, yyyy"
			class="form-control wb-datepicker">
			</div><!-- /.checkbox -->
		</div>
	</div><!-- /.col-md-6 -->
	<div class="col-md-3">
		<div class="form-group">
			<label for="job_time_requirement">Time Requirement</label>
			<select class="contact-select form-control" name="job_time_requirement">
				<option value="">Select</option>
				@foreach($jobTimeRequirements as $time)
				<option value="{{ $time->id }}"
					@if (request('job_time_requirement') == $time->id)
						selected
					@endif
					>
					{{ $time->name }}
				</option>
				@endforeach
			</select>
		</div>
	</div><!-- /.col-md-6 -->
	<div class="col-md-3">
		<div class="form-group">
			<label for="event">Event Type</label>
			<select class="contact-select form-control" name="event">
				<option value="">Select</option>
				@foreach($eventTypes as $event)
				<option value="{{ $event->id }}"
					@if (request('event_id') == $event->id)
						selected
					@endif
					>
					{{ $event->name }}
				</option>
				@endforeach
			</select>
		</div>
	</div><!-- /.col-md-6 -->
</div><!-- /.row -->

@push('scripts')
<script type="text/javascript">
	$('.toggle-advsearch').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		$('.adv-search').toggleClass('active')
	});
</script>
@endpush
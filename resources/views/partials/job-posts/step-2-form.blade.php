<div class="tab-pane fade" id="step-2">
	<p id="no-selected-job-category">Please specify what you need from step 1.</p>
	{{-- <h1 class="title template template-1-title"> What sort of venue do you want? </h1> --}}
	<h1 class="title template template-1-title"> Please provide some more detail. </h1>
	<br>
	<div class="template">
		<div class="wb-form-group approx">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1"> <i class="fa fa-users"></i> </span>
				<input id="approximate" name="number_of_guests" placeholder="Approx number of guests" value="{{ isset($jobPost) ? $jobPost->number_of_guests : old('number_of_guests') }}" type="number" class="form-control">
			</div>
		</div>
		<div id="template"></div>
		<br>
	</div>
	{{-- <div id="beauty-subcategories-input" class="template">
		<div class="wb-form-group">
			<select name="beauty_subcategories_id" class="form-control">
				<option value="">Select</option>
				@foreach($beautySubcategories as $cat)
				<option value="{{ $cat->id }}"
					{{ old('beauty_subcategories_id') === $cat->id
					|| isset($jobPost) && $jobPost->beauty_subcategories_id === $cat->id ? 'selected' : ''}}
					>
					{{ $cat->name }}
				</option>
				@endforeach
			</select>
			<label for="">What exactly do you need?</label>
		</div>
		<br>
	</div>
	<div id="required-address-input" class="template">
		<div class="wb-form-group">
			@if (isset($jobPost))
			<textarea name="required_address" placeholder="Venue or address where supplier is required (if known)" class="form-control">{{ $jobPost->required_address }}</textarea>
			@else
			<textarea name="required_address" placeholder="Venue or address where supplier is required (if known)" class="form-control">{{ old('required_address') }}</textarea>
			@endif
		</div>
	</div>
	<div id="number-of-guests-input" class="template">
		<div class="wb-form-group">
			@if (isset($jobPost))
			<input name="number_of_guests" placeholder="Approx number of guests *" value="{{ $jobPost->number_of_guests }}" type="number" class="form-control">
			@else
			<input name="number_of_guests" placeholder="Approx number of guests *" value="{{ old('number_of_guests') }}" type="number" class="form-control">
			@endif
		</div>
		<br>
	</div>
	<div id="completion-date-input" class="template" style="margin-bottom: 20px;">
		<div data-provide="datepicker" data-date-format="dd/mm/yyyy" class="wb-form-group input-group date">
			<input type="text"
			onkeydown="return false"
			name="completion_date"
			@if (isset($jobPost))
			value="{{ $jobPost->completion_date }}"
			@else
			value="{{ old('completion_date') }}"
			@endif
			data-date-start-date="+1d"
			class="form-control">
			<label for="completion_date" style="font-weight: 100;">Which date do you need this completed by?</label>
			<div class="input-group-addon" style="display: none;">
				<span class="fa fa-calendar"></span>
			</div>
		</div>
		<br>
	</div>
	<div id="time-required-input" class="template">
		<div class="wb-form-group">
			<select name="job_time_requirement_id" class="form-control">
				<option value="" class="grey-input">Time Required</option>
				@foreach($jobTimeRequirements as $time)
				<option value="{{ $time->id }}"
					{{ old('job_time_requirement_id') === $time->id
					|| isset($jobPost) && $jobPost->job_time_requirement_id === $time->id ? 'selected' : ''}}
					>
					{{ $time->name }}
				</option>
				@endforeach
			</select>
		</div>
		<br>
	</div>
	<div id="property-types-input" class="template">
		<div class="wb-form-group">
			<label>Property Types</label>
			<br>
			@php
			if(isset($jobPost)) {
				$currentPropertyTypeIds = $jobPost->propertyTypes->pluck('id')->toArray();
			}
			@endphp
			@foreach($propertyTypes as $prop)
			<input id="prop-{{ $prop->id }}"
			@if (isset($jobPost)
			&& in_array($prop->id, $currentPropertyTypeIds)
			|| in_array($prop->id, old('property_types') ?: []))
			checked
			@endif
			type="checkbox"
			name="property_types[]"
			value="{{ $prop->id}}"
			>
			<label for="prop-{{ $prop->id }}">{{ $prop->name }}</label>&nbsp;&nbsp;
			@endforeach
		</div>
		<br>
	</div>
	<div id="website-requirements-input" class="template">
		<div class="wb-form-group">
			<label><b>Website Requirements</b></label>
			<br>
			@php
			if(isset($jobPost)) {
				$currentWebsiteRequirementIds = $jobPost->websiteRequirements->pluck('id')->toArray();
			}
			@endphp
			@foreach($websiteRequirements as $req)
			<input id="req-{{ $req->id }}"
			@if (isset($jobPost)
			&& in_array($req->id, $currentWebsiteRequirementIds)
			|| in_array($req->id, old('website_requirements') ?: []))
			checked
			@endif
			type="checkbox"
			name="website_requirements[]"
			value="{{ $req->id}}"
			>
			<label for="req-{{ $req->id }}">{{ $req->name }}</label>&nbsp;&nbsp;
			@endforeach
		</div>
		<br>
	</div>
	<div id="other-requirements-input" class="template">
		<div class="wb-form-group">
			<label>Other Requirements</label>
			<br>
			@php
			if(isset($jobPost)) {
				$currentJobRequirementsIds = $jobPost->propertyFeatures->pluck('id')->toArray();
			}
			@endphp
			@foreach($propertyFeatures as $feature)
			<input id="feature-{{ $feature->id }}"
			@if (isset($jobPost)
			&& in_array($feature->id, $currentJobRequirementsIds)
			|| in_array($feature->id, old('property_features') ?: []))
			checked
			@endif
			type="checkbox"
			name="property_features[]"
			value="{{ $feature->id}}"
			>
			<label for="feature-{{ $feature->id }}">{{ $feature->name }}</label>&nbsp;&nbsp;
			@endforeach
		</div>
		<br>
	</div>
	<div id="shipping-address-input" class="template">
		<label><b>If items require shipping, what is your postal address?</b></label>
		<br>
		<div class="wb-form-group">
			<input id="street" name="shipping_address[street]" type="text" class="form-control">
			<label for="street">PO Box or Street Address</label>
		</div>
		<br>
		<div class="wb-form-group">
			<input id="suburb" name="shipping_address[suburb]" type="text" class="form-control">
			<label for="suburb">Suburb</label>
		</div>
		<br>
		<div class="wb-form-group">
			<input id="state" name="shipping_address[state]" type="text" class="form-control">
			<label for="state">State</label>
		</div>
		<br>
		<div class="wb-form-group">
			<input id="post_code" name="shipping_address[post_code]" type="text" class="form-control">
			<label for="post_code">Post Code</label>
		</div>
		<br>
	</div> --}}
	<div class="action-buttons">
		@if(Auth::user())
		<button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
		@endif
		<a href="#" onClick="event.preventDefault(); moveToStep('step-3-section');" class="btn wb-btn wb-btn-primary">NEXT STEP</a>
	</div>
</div>
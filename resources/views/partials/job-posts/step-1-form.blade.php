<div class="tab-pane fade in active" id="step-1">
	<h1 class="title"> What are you looking for? </h1>
	<div class="wb-form-group">
		<select id="job_category_id" name="category_id" class="form-control">
			<option value="" disabled selected>What do you need? <span class="required">*</span></option>
			@foreach($categories as $category)
			<option value="{{ $category->id }}"
				@if (isset($jobPost) && $jobPost->category_id == $category->id)
				selected
				@elseif ((old('category_id') == $category->id) || (request()->category == $category->name))
				selected
				@endif
				data-template="{{ $category->template }}"
				>
				{{ $category->name }}
			</option>
			@endforeach
		</select>
		<!-- <label for="">What do you need? <span class="required">*</span></label> -->
	</div>
	<br>
	<div id="location-input" class="wb-form-group">
		<div class=""> <!-- class: dropdown -->
			<div class="form-group">
				<dl class="selectdropdown jobstep" style="width: 100%;">
					<dt>
						<a class="dropdown selectarrow">
							<p class="multiSel" id="vendor-location-selection" style="max-width: 300px;">
								<span title="wedBooker" style="display: {{ (old('locations') || request()->locations || isset($jobPost)) ? 'none' : 'block' }}">Where do you need it? *</span>
								@if(isset($jobPost) && null === old('locations'))
									@foreach($jobPost->locations()->pluck('name') as $location)
									<span title="{{ $location }}">{{ $location }},</span>
									@endforeach
								@elseif(old('locations'))
									@foreach(old('locations') as $location)
									<span title="{{ $location }}">{{ ($location) }},</span>
									@endforeach
								@elseif(request()->locations)
									@foreach(request()->locations as $location)
									<span title="{{ $location  }}">{{ ($location) }},</span>
									@endforeach
								@endif
							</p>
						</a>
					</dt>
					<dd>
						<div class="mutliSelect">
							<ul>
								@if(isset($jobPost) && null === old('locations'))
									@foreach ($locationsByState as $states)
										@foreach ($states as $key1 => $locs)
											@if($key1 != 'Australia Wide')
												<li class="statename">
													<div class="toggleLocations text-primary">
														{{ $key1 }} <i class="fa fa-plus"></i>
													</div>
													<ul class="stateunder">
														@foreach ($locs as $key2 => $loc)
														<li>
														<input type="checkbox"
														@if((is_array($jobPost->locations()->pluck('name')->toArray()) && (in_array($loc['name'], $jobPost->locations()->pluck('name')->toArray()))))
														checked
														@endif
														name="locations[]"
														id="loc{{ $key1.$key2 }}"
														value="{{ $loc['name'] }}" />
														<label for="loc{{ $key1.$key2 }}">{{ $loc['name'] }}</label>
														</li>
														@endforeach
													</ul>
												</li>
											@endif
										@endforeach
									@endforeach
								@else
									@foreach ($locationsByState as $states)
										@foreach ($states as $key1 => $locs)
											@if($key1 != 'Australia Wide')
												<li class="statename">
													<div class="toggleLocations text-primary">
														{{ $key1 }} <i class="fa fa-plus"></i>
													</div>
													<ul class="stateunder">
														@foreach ($locs as $key2 => $loc)
														<li>
														<input type="checkbox"
														@if((is_array(old('locations')) && in_array($loc['name'], old('locations'))) || (is_array(request()->locations) && in_array($loc['name'], request()->locations)))
														checked
														@endif
														name="locations[]"
														id="loc{{ $key1.$key2 }}"
														value="{{ $loc['name'] }}" />
														<label for="loc{{ $key1.$key2 }}" style="margin: 0;">{{ $loc['name'] }}</label>
														</li>
														@endforeach
													</ul>
												</li>
											@endif
										@endforeach
									@endforeach
								@endif
							</ul>
						</div>
					</dd>
				</dl>
			</div>
		</div>
		<!-- <label>Locations</label> -->
	</div>
	<br>
	<div class="wb-form-group">
		<select name="event_id" class="form-control">
			<option value="" disabled selected>What is the event type? <span class="required">*</span></option>
			@foreach($eventTypes as $event)
			<option value="{{ $event->id }}"
				@if (isset($jobPost) && $jobPost->event_id == $event->id)
				selected
				@elseif (old('event_id') == $event->id)
				selected
				@endif
				>
				{{ $event->name }}
			</option>
			@endforeach
		</select>
		<!-- <label for="">What is the event type? <span class="required">*</span></label> -->
	</div>
	<br>
	
	<div data-provide="datepicker"
		data-date-format="dd/mm/yyyy"
		data-date-start-date="+1d"
		class="wb-form-group input-group date bootstrap-timepicker"
		style="margin-bottom: 0;">
		<div class="input-group">
			<div class="input-group-addon">
				<span class="fa fa-calendar"></span>
			</div>
			<input id="jobDate"
				type="text"
				onkeydown="return false"
				name="event_date"
				@if (isset($jobPost))
				value="{{ $jobPost->event_date }}"
				@else
				value="{{ old('event_date') }}"
				@endif
				class="form-control"
				placeholder="Event date (if known)"
				title="If you don't know your event date but have an approximate date or date range, please add this into Step 3" data-toggle="tooltip">
				
			<div class="input-group-addon" onclick="$('#jobDate').val('')">
				<span class="fa fa-times text-danger"></span>
			</div>
		</div>
	</div>

	<div class="btn-block" style="margin: 0;">
		<input type="checkbox" id="flexible_date" name="flexible_date" class="vendor-expertise" 
		@if (isset($jobPost))
		{{ $jobPost->is_flexible ? 'checked' : '' }}
		@else
		{{ old('flexible_date') ? 'checked' : '' }}
		@endif
		>
		<label for="flexible_date">My dates are flexible or unconfirmed</label>
	</div>
	<br>
	{{-- <div class="wb-form-group">
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1"> <i class="fa fa-dollar"></i> </span>
			<input name="budget"
				@if (isset($jobPost))
				value="{{ $jobPost->budget }}"
				@else
				value="{{ old('budget') }}"
				@endif
				type="text"
				class="form-control"
				placeholder="Max Budget (optional)">
		</div>
	</div>
	<br> --}}
<div class="action-buttons">
	@if(Auth::user())
	<button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
	@endif
	<a href="#" onClick="event.preventDefault(); moveToStep('step-2-section');" class="btn wb-btn wb-btn-primary">NEXT STEP</a>
</div>
</div>
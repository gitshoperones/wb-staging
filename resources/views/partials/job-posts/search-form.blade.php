<form method="GET"
	action="{{ $action }}">
	<div class="search-wrapper">
	<div class="row">
		<div class="col-lg-3">
			<div class="">
				<div class="select-group">
					<label for="">Category</label>
					<dl class="selectdropdown" style="width: 100%;">
						<dt>
							<a class="dropdown">
								<p class="multiSel">
									<i class="fa fa-caret-down pull-right text-primary" style="margin-top: 5px;"></i>
									@if(request('category'))
									@foreach(request('category') as $category)
									<span title="{{ $category }},">{{ $category }},</span>
									@endforeach
									@endif
								</p>
							</a>
						</dt>

						<dd>
							<div class="mutliSelect">
								<ul>
									@foreach ($categories as $category)
									<li>
										<input type="checkbox"
										@if(request('category') && in_array($category['name'], request('category')))
										checked
										@endif
										name="category[]"
										id="cat{{ $loop->index }}"
										value="{{ $category['name'] }}"
										>
										<label for="cat{{ $loop->index }}">{{ $category['name'] }}</label>
									</li>
									@endforeach
								</ul>
							</div>
						</dd>
					</dl>
				</div>
			</div>
		</div>
        @if (!isset($hideLocationSearch) || !$hideLocationSearch)
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Region</label>
                    <!-- <select-locations locations="{{ json_encode($locationsByState) }}"
                        query="{{ json_encode(request('locations')) }}"></select-locations> -->
					<div class=""> <!-- class: dropdown -->
						<div class="form-group">
							<dl class="selectdropdown" style="width: 100%;">
								<dt>
									<a class="dropdown">
										<p class="multiSel" id="vendor-location-selection">
											<i class="fa fa-caret-down pull-right" style="margin-top: 5px;"></i>
											@if(is_array(request('locations')) && count(request('locations')) > 0)
											@foreach(request('locations') as $location)
											<span title="{{ $location }},">{{ $location }},</span>
											@endforeach
											@endif
										</p>
									</a>
								</dt>
								<dd>
									<div class="mutliSelect">
										<ul>
											@foreach ($locationsByState as $states)
												@foreach ($states as $key1 => $locs)
													<li class="statename">
														<div class="toggleLocations text-primary">
															{{ $key1 }} <i class="fa fa-plus"></i>
														</div>
														<ul class="stateunder">
															@foreach ($locs as $key2 => $loc)
															<li>
																<input type="checkbox"
																@if(is_array(request('locations')) && in_array($loc['name'], request('locations')))
																checked
																@endif
																name="locations[]"
																id="loc{{ $key1.$key2 }}"
																value="{{ $loc['name'] }}" />
																<label for="loc{{ $key1.$key2 }}" style="text-transform: capitalize;">{{ $loc['name'] }}</label>
															</li>
															@endforeach
														</ul>
													</li>
												@endforeach
											@endforeach
										</ul>
									</div>
								</dd>
							</dl>
						</div>
					</div>
                </div>
            </div>
        @endif
		<div class="col-lg-2">
			<div class="form-group">
                <label for="event">Event Type</label>
                <select name="event" class="contact-select form-control">
                    <option value=""></option>
                    @foreach($eventTypes as $event)
                    <option value="{{ $event->id }}"
                        @if (request('event') == $event->id)
                            selected
                        @endif
                        >
                        {{ $event->name }}
                    </option>
                    @endforeach
                </select>
            </div>
		</div>
		<div class="col-lg-2">
			<label for="" style="visibility: hidden;">.</label>
			<input type="submit" class="btn wb-btn-orange form-control" style="width: 100%;" value='Search'>
		</div>
		<div class="col-lg-2">
			<label for="" style="visibility: hidden;">.</label>
			<a href="{{ url($action) }}" class="btn wb-btntline-pink form-control"  style=""> Clear</a>
		</div>
	</div><!-- /.row -->
	</div>
</form>
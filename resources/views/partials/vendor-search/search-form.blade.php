<form action="{{ $url ?? url('/suppliers-and-venues') }}" method="GET" class="search">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="form-group">
				<!-- <label for="">CATEGORY</label> -->
				<div class=""> <!-- class: dropdown -->
					<div class="form-group">
						<dl class="selectdropdown vendorsearch" style="width: 100%;">
							<dt>
								<a class="dropdown">
									<p class="multiSel" id="vendor-category-selection">
									<i class="fa fa-caret-down pull-right" style="margin-top: 5px;"></i>
										<span title="wedBooker" style="color: #bbb; font-weight: normal; display: {{ (request('expertise')) ? 'none' : 'inline-block' }}">What do you need</span>
										@if(is_array(request('expertise')) && count(request('expertise')) > 0)
										@foreach(request('expertise') as $expertise)
										<span title="{{ $expertise }}">{{ $expertise }},</span>
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
											@if(is_array(request('expertise')) && in_array($category['name'], request('expertise')))
											checked
											@endif
											name="expertise[]"
											id="cat{{ $loop->index }}"
											value="{{ $category['name'] }}" />
											<label for="cat{{ $loop->index }}" class="drop">{{ $category['name'] }}</label>
										</li>
										@endforeach
									</ul>
								</div>
							</dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="form-group">
				<!-- <label for="">REGION</label> -->
				<!-- <select-locations locations="{{ json_encode($locationsByState) }}" query="{{ json_encode(request('locations')) }}"></select-locations> -->
				<div class=""> <!-- class: dropdown -->
					<div class="form-group">
						<dl class="selectdropdown vendorsearch" style="width: 100%;">
							<dt>
								<a class="dropdown">
									<p class="multiSel" id="vendor-location-selection">
										<i class="fa fa-caret-down pull-right" style="margin-top: 5px;"></i>
										<span title="wedBooker" style="color: #bbb; font-weight: normal; display: {{ (request('locations') || request('states')) ? 'none' : 'inline-block' }}">Region</span>
										@if(is_array(request('states')) && count(request('states')) > 0)
											@foreach(request('states') as $state)
												<span title="{{ $state }}">{{ $state }},</span>
											@endforeach
										@endif
										@if(is_array(request('locations')) && count(request('locations')) > 0)
											@foreach(request('locations') as $location)
												<span title="{{ $location }}">{{ $location }},</span>
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
												@if($key1 != 'Australia Wide')
													<li class="statename">
														<div class="toggleLocations text-primary">
															<i class="fa fa-plus"></i>
															<input type="checkbox"
																@if(is_array(request('states')) && in_array($key1, request('states')))
																checked
																@endif
																name="states[]"
																id="loc{{ $key1 }}"
																value="{{ $key1 }}" />
																<label for="loc{{ $key1 }}" class="drop drop-head"></label><span class="drop-head">{{ $key1 }}</span>
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
																<label for="loc{{ $key1.$key2 }}" class="drop">{{ $loc['name'] }}</label>
															</li>
															@endforeach
														</ul>
													</li>
												@endif
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
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="form-group">
				<!-- <label for="owner_name">Business Name</label> -->
				<div class="input-bordered">
					<input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="Keyword Search">
				</div>
			</div>
		</div>
		<!-- <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<div class="form-group">
				<div class="input-bordered">
					<input type="text" class="form-control" name="venue_capacity" value="{{ request('venue_capacity') }}" placeholder="Property Capacity">
				</div>
			</div>
		</div> -->
	</div>
	<div class="row">
		<div class="col-xs-none col-sm-3 col-md-3 col-lg-2"></div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-4">
			<div class="form-group clear-btn">
				<a href="{{ url('/suppliers-and-venues') }}" class="btn text-black wb-btn-lightgray form-control">Clear Filters</a>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-4">
			<div class="form-group search-btn">
				<input type="submit" value="{{ ($pageSettings->firstWhere('meta_key', 'search_text')) ? strip_tags($pageSettings->firstWhere('meta_key', 'search_text')->meta_value) : "Search" }}" class="btn wb-btn-orange form-control">
				<a href="{{ url('/suppliers-and-venues') }}" class="clear-filters">Clear Filters</a>
			</div>
		</div>
		<div class="col-xs-none col-sm-3 col-md-3 col-lg-2"></div>
	</div>
	{{-- @include('partials.vendor-search.advance-vendor-filters') --}}
</form>
{{-- @if (!isset($hideMoreFilters) || !$hideMoreFilters)
<a href="#" class="toggle-advsearch pull-left"
style="display: inline-block;"
data-toggle="modal"
data-target="#modal-advsearch">
<u>More Filters</u>
</a>
<br/>
@endif --}}
@push('css')
<style>
label.drop {
	text-transform: capitalize;
	display: inline;
	cursor: pointer;
}
label.drop.drop-head {
	font-weight: bold;
}
</style>
@endpush
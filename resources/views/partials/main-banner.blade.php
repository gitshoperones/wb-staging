<div id="wb-big-banner" style="background-image: url({{ ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? Storage::url($result->meta_value) : asset('/assets/images/banners/homepage.png') }});">
	<div class="wb-big-banner-content">
		<div class="site-logo">
			<img src="{{ ($result = $pageSettings->firstWhere('meta_key', 'banner_logo')) ? Storage::url($result->meta_value) : asset('/assets/images/logo-white.png') }}" alt="wedBooker Icon">
		</div>
		<h1>{!! $pageSettings->firstWhere('meta_key', 'banner_text')->meta_value ?? 'Weddings without limits' !!}</h1>
		<form method="GET" id="get-quote">
			<div id="wb-action-buttons" class="row container">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<dl class="selectdropdown mainban">
						<dt>
							<a class="dropdown">
								<p class="multiSel" id="vendor-category-selection">
									<span title="wedBooker">What do you need?</span>
									<span class="categs"></span>
								</p>
								<i class="fa fa-caret-down text-primary pull-right"></i>
							</a>
						</dt>
						<dd>
							<div class="mutliSelect">
								<ul>
									@foreach ($categories as $category)
									<li>
										<input type="radio"
										name="category"
										id="cat{{ $category['name'] }}"
										value="{{ $category['name'] }}" />
										<label for="cat{{ $category['name'] }}">{{ $category['name'] }}</label>
									</li>
									@endforeach
								</ul>
							</div>
						</dd>
					</dl>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<dl class="selectdropdown mainban">
						<dt>
							<a class="dropdown">
								<p class="multiSel" id="vendor-location-selection">
									<span title="wedBooker">Where do you need it?</span>
								</p>
								<i class="fa fa-caret-down pull-right"></i>
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
														{{ $key1 }} <i class="fa fa-plus"></i>
													</div>
													<ul class="stateunder">
														@foreach ($locs as $key2 => $loc)
														<li>
															<input type="checkbox"
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
								</ul>
							</div>
						</dd>
					</dl>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
					<button type="button" class="wb-btn-lg wb-btn-orange get-quote" 
					data-toggle="modal" data-target="#start-planning"
					>{!! $pageSettings->firstWhere('meta_key', 'banner_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'banner_button')->meta_value) : 'Start Booking' !!}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="caption">{!! $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Andreas Holm' !!}</div><!-- /.caption -->
</div>
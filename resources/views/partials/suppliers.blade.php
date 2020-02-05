<div id="wb-suppliers" class="wb-secondary-box">
	<h1 class="wb-title no-underline">{!! $pageSettings->firstWhere('meta_key', 'services_title')->meta_value ?? "MEET OUR SUPPLIERS & VENUES" !!}</h1>
	<div class="container" style="margin-bottom: 40px">
		<div class="row">
			<div class="col-md-12">
				<div class="carousel slide media-carousel" id="media">
					<div class="carousel-inner">
						<div class="item active">
							@foreach (['left', 'middle', 'right'] as $item)
								<div class="supplier-item">
									<a class="thumbnail" style="height: auto;" href="{!! $pageSettings->firstWhere('meta_key', "services_section_{$item}_link") ? strip_tags($pageSettings->firstWhere('meta_key', "services_section_{$item}_link")->meta_value) : '#' !!}">
										<div class="image">
											<img class="lazy img-responsive" data-src="{{ ($result = $pageSettings->firstWhere('meta_key', "services_section_{$item}_img")) ? Storage::url($result->meta_value) : '' }}" />
										</div>
										<div class="content">
											<h5>{!! $pageSettings->firstWhere('meta_key', "services_section_{$item}_title")->meta_value ?? '' !!}</h5>
											<div class="cat">{!! $pageSettings->firstWhere('meta_key', "services_section_{$item}_meta_tag")->meta_value ?? '' !!}</div>
											<p>{!! $pageSettings->firstWhere('meta_key', "services_section_{$item}_text")->meta_value ?? '' !!}</p>
											<button class="btn btn-orange" style="margin-top: 11px;">Request Quote</button>
										</div>
									</a>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="action">
		<a href="{{ url('/suppliers-and-venues') }}" class="wb-btn-lg wb-btn-purple">{!! ($pageSettings->firstWhere('meta_key', 'suppliers_button_text')) ? strip_tags($pageSettings->firstWhere('meta_key', 'suppliers_button_text')->meta_value) : "Browse Our Suppliers & Venues" !!}</a>
	</div>
</div>
<div id="wb-what">
	<div class="container" >
		<h1 class="wb-title no-underline">
			<img data-src="{{ ($result = $pageSettings->firstWhere('meta_key', 'what_title')) ? Storage::url($result->meta_value) : asset('assets/images/what_is_wedbooker/Title_preview.png') }}" class="lazy wb-icon" />
		</h1>
		<div class="row">
			@foreach (['left', 'middle', 'right'] as $item)
				<div class="col-xs-12 col-sm-4 col-md-4 wb-content">
					<div class="item">
						<img data-src="{{ ($result = $pageSettings->firstWhere('meta_key', "what_section_{$item}_img")) ? Storage::url($result->meta_value) : '' }}" class="lazy wb-icon" />
						<p class="wb-lead">{!! $pageSettings->firstWhere('meta_key', "what_section_{$item}_title")->meta_value ?? '' !!}</p>
						<p class="wb-details">{!! $pageSettings->firstWhere('meta_key', "what_section_{$item}_text")->meta_value ?? '' !!}</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
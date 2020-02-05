<div id="wb-why" class="wb-why">
	<div class="container">
		<h1 class="wb-title no-underline">
			<img class="lazy" data-src="{{ ($result = $pageSettings->firstWhere('meta_key', 'why_title')) ? Storage::url($result->meta_value) : asset('assets/images/why_use_wedbooker/Title_preview.png') }}" alt="">
		</h1>
		<!-- Wrapper for slides -->
		<div class="item-inner">
			<div class="row d-flex">
					@foreach($why['title'] as $key => $whyT)
					<div class="col-md-3 col-sm-12 text-primary">
						
						<img data-src="@foreach($why['img'] as $whyImg){!! (substr($whyImg->meta_key, strpos($whyImg->meta_key, "_") + 1) == substr($whyT->meta_key, strpos($whyT->meta_key, "_") + 1)) ? Storage::url($whyImg->meta_value) : "" !!}@endforeach" class="lazy wb-icon img-responsive">
						<p class="wb-lead">{!! strip_tags($whyT->meta_value) !!}</p>
						<p class="wb-details">
							@foreach($why['text'] as $whyTx)
								{!! (substr($whyTx->meta_key, strpos($whyTx->meta_key, "_") + 1) == substr($whyT->meta_key, strpos($whyT->meta_key, "_") + 1)) ? strip_tags($whyTx->meta_value) : "" !!}
							@endforeach
						</p>
					</div>
					@endforeach
			</div>
		</div>
	</div>
</div>

<section id="wb-testimonials" class="wb-lighter-box">
	<div class="container">
		<h1 class="wb-title no-underline">
			<img class="lazy" style="max-width: 500px; width: 100%;" data-src="{{ ($result = $pageSettings->firstWhere('meta_key', 'testimonials_title')) ? Storage::url($result->meta_value) : asset('assets/images/testimonials/Title_preview.png') }}" alt="">
		</h1>
		<div class="card-wrapper testimonials-slider">
			@foreach($testimonials['title'] as $key => $title)
				<div class="card">
					<div class="item">
						<div class="card-image">
							<img class="img-circle" @foreach($testimonials['img'] as $image)
							{!! (substr($image->meta_key, strrpos($image->meta_key, "_") + 1) == substr($title->meta_key, strrpos($title->meta_key, "_") + 1)) ? 'data-lazy="' . Storage::url($image->meta_value) . '"' : "" !!}
							@endforeach />
						</div>
						<div class="card-info">
							@foreach($testimonials['text'] as $text)
								{!! (substr($text->meta_key, strrpos($text->meta_key, "_") + 1) == substr($title->meta_key, strrpos($title->meta_key, "_") + 1)) ? $text->meta_value : "" !!}
							@endforeach
							<div class="card-name">{!! strip_tags($title->meta_value) !!}</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

@push('css')
<link href="{{ asset('assets/js/slick-slider/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/js/slick-slider/slick-theme.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('assets/js/slick-slider/slick.min.js') }}"></script>
<script>
$(document).ready(function(){
  $('.testimonials-slider').slick({
	autoplay: true,
	autoplaySpeed: 5000,
	lazyLoad: 'ondemand'
  });
});
</script>
@endpush
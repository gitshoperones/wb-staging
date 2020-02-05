@if (count($gallery) > 0 || $editing === 'editOn')
<div class="wb-gallery {{ $editing }}">
	@if ($editing === 'editOn')
		@include('partials.profiles.gallery-upload')
	@endif
	<div class="card-wrapper" id="image-wrapper">
		@foreach ($gallery as $photo)
			<div class="card" data-id="{{ $photo->id }}">
				<div class="item">
					@if($editing === 'editOff') <a href="{{ $photo->getFileUrl() }}" data-lightbox="gallery-images" data-title="{{ $photo->getFileCaption() }}"> @endif
						<div class="card-image" {!! "data-id=$photo->id data-url={$photo->getFileUrl()} data-position=\"{$photo->getFilePosition()}\"" !!}>
							<p class="caption">{{ $photo->getFileCaption() }}</p>
						</div>
					@if($editing === 'editOff') </a> @endif
				</div>
			</div>
		@endforeach
	</div>
</div>
@endif

@push('css')
<link href="{{ asset('assets/js/slick-slider/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/js/slick-slider/slick-theme.css') }}" rel="stylesheet" />
@if($editing === 'editOff')
<style>
a:focus {
	outline: none;
}
</style>
@endif
@endpush

@push('scripts')
<script src="{{ asset('assets/js/slick-slider/slick.min.js') }}"></script>
<script>
var image_wrapper = $('#image-wrapper'),
	isSlickLoaded = $('.slick-initialized').length;

$(document).ready(function(){
	if(image_wrapper.find(".card").length > 1) {
		initSlick();
	}else {
		image_wrapper.find(".card .item").show();
	}
	
	updateSliderImage();

	{{ $editing == 'editOn' ? "updateSortImage();" : "" }}
});

function initSlick() {
	image_wrapper.slick({
		autoplay: true,
		autoplaySpeed: 5000,
		slidesToShow: 1,
		variableWidth: true,
		centerMode: true,
		centerPadding: '60px'
	});
	
	isSlickLoaded = $('.slick-initialized').length;
}

function updateSliderImage() {
	$('#image-wrapper .card-image').each(function() {
		var element = $(this);

		if(element.attr('data-id') !== undefined) {
			element.css('background-image', `url(${element.attr('data-url')})`)
				.css('background-position', element.attr('data-position'));
		}
	});
}

function updateSortImage() {
	$('#image-wrapper-sort .card-image').each(function() {
		var element = $(this);

		if(element.attr('data-id') !== undefined) {
			element.css('background-image', `url(${element.attr('data-url')})`)
				.css('background-position', element.attr('data-position'));
		}
	});
}
</script>
@endpush
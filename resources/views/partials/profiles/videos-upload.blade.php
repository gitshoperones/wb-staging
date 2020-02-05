<div class="wb-profile-videos">
	{{-- @if( ! $userProfile->embedded_video) --}}
	{{-- <button type="button" id="upload-video" class="btn btn-danger" style="margin-bottom: 10px">ADD VIDEOS OF YOUR WORK</button> --}}
	<button type="button" id="add-more-videos" class="btn btn-danger" style="margin-bottom: 10px">ADD VIDEOS OF YOUR WORK</button>
	{{-- @endif --}}

	<div id="url-inputs" class="form-group"> 
		@if($userProfile->getRawEmbeddedVideo())
			@foreach($userProfile->getRawEmbeddedVideo() as $video)
				<input type="text" name="embedded_video[]" class="form-control input-videos" value="{{ $video }}" placeholder="Add the direct URL to any of your YouTube or Vimeo videos here. Note, these videos must be of your own work.">
			@endforeach
		@endif
		<input type="text" name="embedded_video[]" class="form-control input-videos" placeholder="Add the direct URL to any of your YouTube or Vimeo videos here. Note, these videos must be of your own work.">
	</div>

	{{-- <button type="button" id="add-more-videos" class="btn wb-btn-primary">Add another video</button> --}}
</div>

@push('scripts')
	<script>
		$('#add-more-videos').on('click', function () {
			var input = $('<input>')
				.addClass('form-control input-videos')
				.attr('name', 'embedded_video[]')
				.attr('placeholder', 'Add the direct URL to any of your YouTube or Vimeo videos here. Note, these videos must be of your own work.');

			$('#url-inputs').append(input);
		});
	</script>
@endpush
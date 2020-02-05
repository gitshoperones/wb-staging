<div class="wb-notes-dashboard wb-job-description block editOn">
	@if ($editing === 'editOff')
		<div class="job_desc_display"
			style="text-align: left; font-weight: 300; font-family: 'Ubuntu', sans-serif; letter-spacing: 0.5px;"
			>
			{!! $userProfile->desc !!}
		</div>
	@else
		<div id="profile-desc-editor"></div>
		<input type="hidden" id="account-desc" value='{!! $userProfile->desc !!}'>
	@endif
</div>
@if ($editing === 'editOn')
	@push('css')
		<link href="{{ asset('assets/js/Trumbowyg/ui/trumbowyg.min.css') }}" rel="stylesheet" />
	@endpush
	@push('scripts')
		<script type="text/javascript" src="{{ asset('assets/js/Trumbowyg/trumbowyg.min.js') }}"></script>
		<script type="text/javascript">
			window.profileDescription = '';

			$('#profile-desc-editor').trumbowyg({
				removeformatPasted: true,
				btns: [
					['formatting'],
					['strong', 'em', 'underline'],
					['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
					['unorderedList', 'orderedList'],
				],
			}).on('tbwchange', function(){
				window.profileDescription = $('#profile-desc-editor').trumbowyg('html');
			 }).on('tbwblur', function(){
				window.profileDescription = $('#profile-desc-editor').trumbowyg('html');
			 }).on('tbwfocus', function(){
				window.profileDescription = $('#profile-desc-editor').trumbowyg('html');
			 });
			$('#profile-desc-editor').trumbowyg('html', $('#account-desc').val());
		</script>
	@endpush
@endif

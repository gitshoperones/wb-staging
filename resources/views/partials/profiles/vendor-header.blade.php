<div id="user-profile-wrapper"
	@if ($userProfile->profile_cover)
	style="background-image: url({{ $userProfile->profile_cover }})"
	@endif
    class="wb-cover-vendor profile-wrapper {{ $editing }}">
    <!-- <a href="#" class="btn-request btn btn-orange">request quote</a> -->
    @if ($editing === 'editOff')
        @can('edit-profile', $userProfile)
            <a class="btn btn-danger edittrigger"
                href="{{ url(sprintf('/%ss/%s/edit', Auth::user()->account, $userProfile->id)) }}"
                class="edit-trigger">
                Edit my profile
            </a>
		@endcan
	@else
		<input type="file" id="profile-cover" name="profile_cover" class="hidden" accept=".png, .jpg, .jpeg">
		<span class="right-icon tooltip-icon toolCover">
			<span class="btn exoffers">
				<i class="fa fa-question"></i>
			</span>
			<div class="tooltip-wrapper">
				Recommended dimension: 1140 x 380
			</div>
		</span>
		<label class="btn btn-danger editCover"
			class="edit-trigger"
			for="profile-cover">
			<span class="fa fa-file-image-o"></span>
			Edit Cover Image
		</label>
	@endif
    <div class="profile-img {{ $editing }}">
    	<img id="avatar"
    	@if ($userProfile->profile_avatar)
    	src=" {{ $userProfile->profile_avatar }}"
    	@else
    	src="https://s.gravatar.com/avatar/94122f32bdba75d273960c141f29473e?s=300"
    	@endif
    	class="img-square {{ $editing }}" alt="no image">
    	<input type="file" id="profile-avatar" name="profile_avatar" class="hidden" accept=".png, .jpg, .jpeg">
    	<label id="editImageBtn" for="profile-avatar" class="btn btn-danger">
    		<span class="fa fa-file-image-o"></span>
    		Edit Profile Image
    	</label>
    </div>
    <div class="name">
    	<span class="editOff">{{ $userProfile->business_name }}</span>
		@include('partials.profiles.vendor-stars')
    </div>
</div>

<div id="photo-cropper-section" class="photo-cropper hidden-cropper">
	<div class="cropper-container">
		<div class="row">
			<div class="col-md-12">
				<div id="croppie-image"></div>
				<button type="button" id="crop-image-btn" class="btn btn-orange" id="crop">Crop</button>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
	$('#editImageBtn, #crop-image-btn').on('click', function(event) {
		$('body').toggleClass('crop_active');
	});
</script>
@endpush

@push('css')
<style>
.editCover, .toolCover {
	position: absolute;
	right: 0;
	bottom: -82px;
	z-index: 1;
}
.toolCover {
	right: 165px;
}
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
#user-profile-wrapper {
	padding-bottom: 0;
}
.wb-cover-vendor span.newtowedbooker.btn {
	font-size: 11px;
	border-radius: 6px;
    color: #373654;
    background-color: #E7D8D1;
}
</style>
@endpush
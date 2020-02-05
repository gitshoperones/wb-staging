<div class="tab-pane fade" id="step-3">
	<h1 class="title">Option to provide more detail<br/><small class="text-primary">(or you can skip this step)</small></h1>
	<br>
	<p id="custom-text" class="text-primary"></p>
	<div class="wb-form-group">
		<textarea name="specifics" id="additional-options" class="form-control" rows="4">{{ isset($jobPost) ? $jobPost->specifics : "" }}</textarea>
	</div>
	{{-- <input type="hidden" name="specifics" id="job-specifics" value='{!! isset($jobPost) ? $jobPost->specifics : "" !!}'>
	<div class="wb-notes-dashboard ">
		<div id="job-specifics-editor" style="text-align: left;"></div>
	</div> --}}
	<br>
	{{-- <div class="action-buttons">
		@if(Auth::user())
		<button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
		@endif
		<a href="#" onClick="event.preventDefault(); moveToStep('step-5-section');" class="btn wb-btn wb-btn-primary">NEXT STEP</a>
	</div> --}}
	@if(request()->vendor_id)
        <div class="action-buttons">
            @if(Auth::user())
            <button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
            @endif
            <a href="#" onClick="event.preventDefault(); moveToStep('step-5-section');" class="btn wb-btn wb-btn-primary">Next Step</a>
        </div>
    @else
		@if(Auth::user())
        <div class="action-buttons">
            <button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
            <button id="{{ (request()->vendor_id) ? "submit-quote-request" : "submit-job-post"}}" type="submit" name="status" value="{{ (isset($jobPost) && $jobPost->status === 1) ? 1 : 5 }}" class="btn wb-btn wb-btn-primary {{ isset($btnLbl) ? "submit-quote-request" : "thank-you" }}">
                {{ isset($btnLbl) ? $btnLbl : 'Post Job'}}
			</button>
            <a href="#" onClick="event.preventDefault(); moveToStep('step-5-section');" class="btn wb-btn wb-btn-primary" style="display: none;">Next Step</a>
        </div>
        @else
        <div class="action-buttons">
            <a href="#" onClick="event.preventDefault(); moveToStep('step-5-section');" class="btn wb-btn wb-btn-primary">Next Step</a>
        </div>
        @endif
    @endif
</div>
@push('css')
<style>
#custom-text {
	font-weight: 100;
	max-width: 375px;
	margin: auto;
}
#additional-options {
	resize: none;
}
</style>
@endpush
{{-- @push('scripts')
<script type="text/javascript" src="{{ asset('assets/js/Trumbowyg/trumbowyg.min.js') }}"></script>
<script type="text/javascript">
	window.jobPostSpecificsEditor = $('#job-specifics-editor');
	var specifics = $('#job-specifics');

	jobPostSpecificsEditor.trumbowyg({
		removeformatPasted: true,
		btns: [
		['formatting'],
		['strong', 'em', 'underline'],
		['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
		['unorderedList', 'orderedList'],
		],
	}).on('tbwchange', function(){
		updateWysiwygContent();
	}).on('tbwblur', function(){
		updateWysiwygContent();
	}).on('tbwfocus', function(){
		updateWysiwygContent();
	});
	jobPostSpecificsEditor.trumbowyg('html', $('#job-specifics').val());
	$('body').on('click', function(){
		updateWysiwygContent();
	});

	function updateWysiwygContent() {
		specifics.val(jobPostSpecificsEditor.trumbowyg('html'));
	}
</script>
@endpush --}}

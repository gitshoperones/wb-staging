<div class="tab-pane" id="tab_step_2">
	<div class=" WA', 'state' => 'Western Australia'],">
		<milestones></milestones>
		<div class="sub-header p-b-xxs">
			Quote Expiry Date
		</div>

        <div data-provide="datepicker"
            data-date-format="dd/mm/yyyy"
			data-date-start-date="+1d"
            class="wb-form-group input-group date">
            <input id="jobDate"
                type="text"
                onkeydown="return false"
                name="duration"
                value="{{ isset($jobQuote) ? $jobQuote->duration : '' }}"
                class="form-control">
            <div class="input-group-addon" style="display: none;">
                <span class="fa fa-calendar"></span>
            </div>
        </div>
		<div class="terms-block">
			<div class="sub-header p-b-xxs" style="width: 100%;">
				Terms and Conditions <br />
				<small style="margin-bottom: 8px;">wedBooker Terms & Conditions apply to all bookings made on wedbooker.com. If you have additional Terms & Conditions, you can upload them here.</small>
				<select name="tac_option" id="quote-tac" style="display: block; width: 100%; padding: 3px 6px; font-size: 14px;">
					<option value="no">I don't have any additional T&C</option>
					<option value="existing" @if(isset($jobQuote) && $jobQuote->tcFile) selected @endif>Use the T&Cs I've uploaded to my settings</option>
					<option value="new">Upload my T&Cs now</option>
				</select>
				<p id="filename">
					@if(isset($jobQuote) && $jobQuote->tcFile)
						<a target="_blank" href="{{ $jobQuote->tcFile->meta_filename }}">{{ $jobQuote->tcFile->meta_original_filename }}</a>
					@endif
				</p>
			</div>
		</div>
	</div>
</div>

<div id="modal-tac" class="wb-modal-quotes-received modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content text-center">
			<div class="modal-body ">
				<input type="file" name="tac_file" id="tac-file" class="hidden">
				<label for="tac-file" class="btn wb-btn-orange wb-btn-md">Select File</a>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
	$('#quote-tac').on('change', function() {
		if($(this).val() == 'new'){
			$('#modal-tac').modal('show');
		}
	});

	$('#tac-file').on('change', function(){
		$('#modal-tac').modal('hide');
		displayFilename();
	});

	function displayFilename() {
		var name = document.getElementById('tac-file');
		var el = $('#filename');
		el.html('');
		el.html(name.files.item(0).name);
	};
</script>
@endpush
<div class="tab-pane active" id="tab_step_1">
	<div class=" WA', 'state' => 'Western Australia'],">
		<div class="sub-header text-color-primary text-normal">
			Itemise your quote
		</div>
		<div class="wb-table-wrapper table-responsive">
			<specifications><specifications>
		</div>
        @if (isset($jobQuote))
            <input type="hidden" id="wbQuote_quoteSpecs" value="{{ json_encode($jobQuote->specs) }}">
            <input type="hidden" id="wbQuote_milestones" value="{{ json_encode($jobQuote->milestones) }}">
        @endif
        <input type="hidden" id="wbQuote_applyGST" value="{{ Auth::user()->vendorProfile->gst_registered }}">
        <input type="hidden" id="wbQuote_totalWedbookerFee" value="{{ $totalWedbookerFee }}">
	</div>
</div>
<script type="text/javascript">
	window._wbQuote_ = {
		totalPayable: 0,
        applyGst: $('#wbQuote_applyGST').val(),
        totalWedbookerFee: $('#wbQuote_totalWedbookerFee').val(),
        quoteSpecs: $('#wbQuote_quoteSpecs').val(),
		milestones: $('#wbQuote_milestones').val(),
	};

	$(function() {
		// var toolTipValue = 'If you are succesful with this booking, the ' + window._wbQuote_.totalWedbookerFee + '% wedBooker fee will be deducted from the total when you receive payment.';
		var toolTipValue = 'This is the amount you will receive into your bank account once the small wedBooker booking fee has been deducted.';
		$('.tool1', this).append('<div class="tooltip-wrapper">'+toolTipValue+'</div>');
	});
</script>
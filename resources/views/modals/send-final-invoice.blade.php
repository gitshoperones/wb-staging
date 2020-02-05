<!-- Search Modal -->
<div class="modal fade" id="send-final-invoice" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
	<div id="wb-modal-success" class="modal-dialog">
		<div class="modal-dialog">
			<div class="modal-content text-center">
				<div class="modal-header">
					Request a Refund
				</div>
				@include('partials.alert-messages')
				<form action="{{ url(sprintf('/job-quotes/%s/invoice', $quote->id)) }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="PATCH">
					<input type="hidden" id="job-quote-id" name="job_quote_id" value="">
					<div class="modal-body ">
						<div class="form-group">
							<input type="file" id="final-invoice" name="invoice" class="hidden" onchange="displayFilename()"/>
							<p id="filename"></p>
							<label for="final-invoice" class="btn wb-btn-disabled wb-btn-round-xs">
								Select File
							</label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn wb-btn-outline-danger">SUBMIT</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function displayFilename() {
			var name = document.getElementById('final-invoice');
			var el = $('#filename');
			el.html('');
			el.html(name.files.item(0).name);
		};
	</script>
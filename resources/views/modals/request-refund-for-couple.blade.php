<!-- Modal -->
<div id="modal-request-refund" class="modal-request-refund modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content text-center">
			<div class="modal-header">
				<h3 class="title">CANCEL BOOKING / REQUEST A REFUND</h3><!-- /.title -->
			</div>
			<div class="modal-body">
				<p>To determine whether a refund is possible we need a few details.</p><br /><br />
				<form method="POST" action="" id="request-refund">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="couple_member">Are you cancelling the booking</label>  <br />
						<input type="radio" name="cancel_booking" id="refundYes" value="Yes" />
						<label for="refundYes">Yes</label> &nbsp; &nbsp; &nbsp;
						<input type="radio" name="cancel_booking" id="refundNo" value="No" checked/>
						<label for="refundNo">No</label>
					</div> <br />
					<div class="form-group">
						<label for="couple_member">Reason you are requesting a refund (please provide details if possible)</label>
						<textarea name="reason" required type="text" class="form-control"></textarea>
					</div> <br />
					<div class="form-group">
						<label for="couple_member">$ Amount Requested for Refund</label>
						<input name="amount" type="text" class="form-control" required>
					</div><br /><br />
					<div class="form-group">
						<button type="submit" class="btn wb-btn-orange">SEND REFUND REQUEST</button>
						<button data-dismiss="modal" class="btn wb-btn-primary">CLOSE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	window.wbQuotes = {list: []};
</script>

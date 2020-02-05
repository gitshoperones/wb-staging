<!-- Modal -->
<div id="modal-delete-account" class="modal-delete-account modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content text-center">
			<div class="modal-header">
				<h3 class="title">We're sad to see you go!</h3><!-- /.title -->
			</div>
			<div class="modal-body">
				<p>So that we can improve the wedBooker experience, <br />please let us know why you are leaving.</p><br /><br />
				<form action="{{ url(sprintf('users/%s', Auth::user()->id)) }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    {{ csrf_field() }}
					<div class="form-group">
						<select name="reason" id="" class="form-control">
							<option value="wedBooker wasn't useful for me">wedBooker wasn't useful for me</option>
							<option value="I got too many notifications and emails">I got too many notifications and emails</option>
							<option value="I didn't receive any work">I didn't receive any work</option>
							<option value="There weren't any suppliers I wanted to book">There weren't any suppliers I wanted to book</option>
							<option value="I had negative experience with a couple">I had negative experience with a couple</option>
							<option value="I had negative experience with a business">I had negative experience with a business</option>
							<option value="Other">Other</option>
						</select>
						<br /><br />
						<textarea name="details" rows="5" class="form-control" placeholder="Please provide more detail"></textarea>
					</div> <br />
					<div class="form-group">
						<button type="submit" class="btn wb-btn-orange" style="margin-top: 0;">Request to delete my account</button>
						<a data-dismiss="modal" class="btn wb-btn-primary">Go back to my account</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Search Modal -->
<div class="modal fade" id="success-del-confirmation" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
	<div id="wb-modal-success" class="modal-dialog">
		<div class="modal-dialog">
			<div class="logo-container">
				<div class="logo">
					<span><i class="fa fa-check"></i></span>
				</div>
			</div>
			<div class="modal-content text-center">
				<div class="modal-header" style="text-transform: none;">
					Your request to delete your account has now been submitted. We will get back to you within 24 hours to confirm deletion.
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
			</div>
		</div>
	</div>
</div>
@if(session()->has('success'))
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function(){
                $('#success-del-confirmation').modal('show');
            })
        </script>
    @endpush
@endif
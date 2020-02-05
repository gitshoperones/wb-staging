<div id="wb-header-alert" class="admin-bar">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="action-button adminbar">
					<span>You are currently in edit mode. Click save button on right to save changes.</span>
					<button id="saveBtn" type="button" class="btn btn-danger btn-sm">Save</button>
					<button id="cancelBtn" type="button" class="btn wb-btn-gray btn-sm">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
	$('#cancelBtn').on('click', function(){
		window.location = "{{ url(sprintf('%ss/%s', Auth::user()->account, $userProfile['id'])) }}";
	})
</script>
@endpush

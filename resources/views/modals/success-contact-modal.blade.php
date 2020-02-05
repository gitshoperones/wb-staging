<!-- Search Modal -->
<div class="modal fade" id="success-confirmation" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
	<div id="wb-modal-success" class="modal-dialog">
		<div class="modal-dialog">
			<div class="logo-container">
				<div class="logo">
					<span><i class="fa fa-check"></i></span>
				</div>
			</div>
			<div class="modal-content text-center">
				<div class="modal-header">
					Thank you for your message
				</div>
				<div class="modal-body ">
					<p>
						A member of the wedBooker team will be in contact shortly.
					</p>
				</div>
				<div class="modal-footer">
					@if (Auth::check())
					<a href="{{ url('dashboard') }}" class="btn wb-btn-outline-primary blur">Back to my dashboard</a>
					@else
                    <a href="{{ url('/sign-up') }}" class="btn wb-btn-outline-primary blur">Sign up now</a>
					<a href="{{ url('/login') }}" class="btn wb-btn-outline-primary blur">Login to my account</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#success-confirmation').modal('show');
	})
</script>
@endpush
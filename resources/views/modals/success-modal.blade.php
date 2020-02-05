<!-- Search Modal -->
<div class="modal fade" id="success-confirmation" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
	<div id="wb-modal-success" class="">
		<div class="modal-dialog">
			<div class="logo-container">
				<div class="logo">
					<span><i class="fa fa-check"></i></span>
				</div>
			</div>
			<div class="modal-content text-center">
				<div class="modal-header">
					{{ $header }}
				</div>
				<div class="modal-body ">
					<p>
						{{ $message }}
					</p>
				</div>
                <div class="form-group">
                    @if (isset($btnLabel) && isset($btnUrl))
                       <a href="{{ $btnUrl }}" class="btn wb-btn-orange">{{ $btnLabel }}</a>
                    @else
                        <a href="" data-dismiss="modal" class="btn wb-btn-primary">Close</a>
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
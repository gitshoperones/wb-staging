
<div class="modal fade" id="error-fields" tabindex="-1" role="dialog" aria-labelledby="requiredFields" aria-hidden="true">
	<div id="wb-modal-success" class="">
		<div class="modal-dialog">
			<div class="logo-container">
				<div class="logo-error">
					<i class="fa fa-times"></i>
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
                        <a href="" data-dismiss="modal" class="btn wb-btn-primary wb-btn-orange">Okay</a>
                    @endif
                </div>
			</div>
		</div>
	</div>
</div>
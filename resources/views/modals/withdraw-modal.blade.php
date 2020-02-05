<!-- Search Modal -->
<div class="modal fade" id="withdraw-confirmation" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
	<div id="wb-modal-withdraw" class="">
		<div class="modal-dialog">
			<div class="logo-container">
				<div class="logo">
					<span><i style="font-size: 42px;" class="fa fa-warning"></i></span>
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
					<br>
				</div>
				<div class="form-group">
					<a href="{{ $btnUrl1 }}" class="btn wb-btn-orange btn-withdraw">{{ $btnLabel1 }}</a>
					<a href="#" data-dismiss="modal" class="btn wb-btn-gray">{{ $btnLabel2 }}</a>
				</div>
			</div>
		</div>
	</div>
</div>
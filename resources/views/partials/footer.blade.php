<footer class="site-footer">
	<div class="copy-contain">
		<div class="row">
			<div class="col-sm-6">
				<div class="logo-footer"><img style="max-width: 45px; margin-top: -9px; margin-right: 7px;" src=" {{ asset('assets/images/wedbooker-white-icon.png') }} " alt=""> </div>
				<div class="copyright item">Copyright &copy; {{ now()->year }} wedBooker Australia Pty Ltd All Rights Reserved.</div>
			</div>
			<div class="col-sm-6" style="text-align: right;">
				<div class="tac item">
					<a href=" {{ url('/community-guidelines')}} ">Community Guidelines</a> &nbsp;&nbsp;&nbsp;
					<a href=" {{ url('/privacy-policy')}} ">Privacy Policy</a> &nbsp;&nbsp;&nbsp;
					<a href=" {{ url('/terms-and-conditions')}} ">Terms & Conditions</a>
				</div>
			</div>
		</div>
	</div>
</footer>
@push('styles')
<style>
	select {
		background: url("{{ asset('assets/images/angle-down-16.png') }}") white no-repeat calc(100% - 10px) !important;
	}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
	$(function() {
		// Mobile menu
		$( window ).resize(function() {
			$( "body" ).removeClass('mobile-active');
		});

		$('.selectdropdown a').on('click', function(event) {
			event.preventDefault();
			/* Act on the event */
		});

		// How it works action buttons
		$('.section-howItWorks .btn').on('click', function() {
			$('.section-howItWorks .btn').removeClass('active');
			$(this).addClass('active');
		});

		$('.wb-faq .wb-action-buttons .btn').on('click', function() {
			$('.wb-faq .wb-action-buttons .btn').addClass('inactive');
			$(this).removeClass('inactive');
		});

		$("[tooltip-value]").each(function( index ) {
			var toolTipValue = $(this).attr('tooltip-value');
			$('.tooltip-icon', this).append('<div class="tooltip-wrapper">'+toolTipValue+'</div>');
		});

		$(window).scroll(function() {
			var wScroll = $(this).scrollTop();
			wScroll = wScroll / 2 * -1;
			wScroll = wScroll + 33;

			wwidth = $( window ).width();

			if ( wwidth > 500 ) {
				$('#wb-big-banner').css({
					'background-position': 'center '+ wScroll +'px',
				});
			}
		});
	});
</script>
@endpush
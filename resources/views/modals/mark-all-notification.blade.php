<div class="modal" tabindex="-1" role="dialog" id="markAll">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{-- <div class="modal-header">
        <h5 class="modal-title">Mark all notifications are read?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> --}}
      <div class="modal-body text-center">
        <p class="text-primary" style="margin: 0; font-weight: 300;">Mark all notifications as read?</p>
      </div>
      <div class="modal-footer" style="text-align: center;">
		<form action="/dashboard/markAll" method="POST">
			@csrf
			<button type="submit" class="btn wb-btn-orange">Yes mark as read</button>
			<button type="button" class="btn wb-btn-gray" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div>
  </div>
</div>

@section('scripts')
	<script>
		$('.unread-notification-indicator').click(function() {
			var notifId = $(this).prop('id');
			$(this).addClass('read');
			markAsRead(notifId);
		});

		$('.custom-btn').click(function(e) {
			e.preventDefault();

			var url = $(this).attr('href'),
				notifId = $(this).attr('data-notifId');

			markAsRead(notifId);
			window.location.href = url;
		});

		const markAllAsRead = () => {
			$('#markAll').modal('show');
		}

		const markAsRead = (notification_id) => {
			$.ajax({
				url: '/dashboard?notificationId='+notification_id,
				beforeSend: function() {
				},
				success: function(result){
					var label = $('.nav a.notifications .label-orange');
					var notifs = parseInt(label.text());
					$('span#'+notification_id).fadeOut('slow');
					label.text(notifs-1);
					(parseInt(label.text())) ? "" : label.fadeOut();
				}
			});
		}
	</script>
@endsection
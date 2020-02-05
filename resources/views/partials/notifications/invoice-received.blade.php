<tr>
	<td>
        @if (!$notification->read_at)
            @include('partials.unread-notification-indicator')
        @endif
        {{ $notification->created_at->diffForHumans()}}
    </td>
	<td>
		<div class="name">
			<strong>{{ $notification->data['title'] ?? '--' }}</strong>
		</div>
		<div class="desc">
			{!! $notification->data['body'] ?? '--' !!}
		</div>
	</td>
	<td>
		<a href="{{ url(sprintf('payments/create?invoice_id=%s&notificationId=%s', $notification->data['invoiceId'] ?? '', $notification->id)) }}"
			class="btn wb-btn-orange">
			View Invoice & Pay Now
		</a>
	</td>
</tr>
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
		<a href="{{ url(sprintf('/dashboard/job-quotes/%s?notificationId=%s', $notification->data['jobQuoteId'], $notification->id)) }}"
			class="btn wb-btn-orange">
			VIEW QUOTE
		</a>
	</td>
</tr>
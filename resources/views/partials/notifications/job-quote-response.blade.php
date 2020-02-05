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
		@if (isset($notification->data['status']) && $notification->data['status'] === 2)
            <a href="{{ url(sprintf('/dashboard/job-quotes/%s/edit?notificationId=%s', $notification->data['jobQuoteId'], $notification->id)) }}"
                class="btn wb-btn-orange">
                EDIT QUOTE
            </a>
            <a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s&notificationId=%s', $notification->data['jobPostUserId'], $notification->id)) }}"
                class="btn wb-btn-orange">
                View Requests
            </a>
        @elseif (isset($notification->data['status']) && $notification->data['status'] === 3)
            <a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s&notificationId=%s', $notification->data['jobPostUserId'], $notification->id)) }}"
                class="btn wb-btn-orange">
                Message Couple
            </a>
        @else
            <a href="{{ url(sprintf('/dashboard/job-quotes/%s?notificationId=%s', $notification->data['jobQuoteId'], $notification->id)) }}"
                class="btn wb-btn-orange">
                VIEW QUOTE
            </a>
		@endif
	</td>
</tr>
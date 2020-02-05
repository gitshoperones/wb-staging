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
        <a href="{{ url(sprintf('/invoice/%s/pdf?notificationId=%s', $notification->data['invoiceId'] ?? '', $notification->id)) }}"
            target="_blank"
            class="btn wb-btn-orange">
            View Invoice
        </a>
    </td>
</tr>
<tr class="signupnotif">
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
        @php
            if (Auth::user()->account === 'vendor') {
                $recipientUserId = $notification->data['coupleUserId'];
            } else {
                $recipientUserId = $notification->data['vendorUserId'];
            }
        @endphp
        <a href="{{ url(sprintf(
            '/dashboard/messages?recipient_user_id=%s&notificationId=%s', $recipientUserId, $notification->id
            )) }}"
            class="btn wb-btn-orange">
            {{ $notification->data['btnTxt'] }}
        </a>
    </td>
</tr>
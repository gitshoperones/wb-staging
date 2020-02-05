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
    @if (isset($notification->data['btnTxt']))
        <td>
            @if ($notification->data['btnLink'] && $notification->data['btnTxt'])
                <a href="{{ sprintf((strpos($notification->data['btnLink'], '?')) ? '%s&notificationId=%s' : '%s?notificationId=%s', $notification->data['btnLink'], $notification->id) }}"
                    class="btn wb-btn-orange">
                    {{ $notification->data['btnTxt'] }}
                </a>
            @endif
            
            @if (isset($notification->data['btnTxt2']))
                @if ($notification->data['btnLink2'] && $notification->data['btnTxt2'])
                    <a href="{{ sprintf((strpos($notification->data['btnLink2'], '?')) ? '%s&notificationId=%s' : '%s?notificationId=%s', $notification->data['btnLink2'], $notification->id) }}"
                        class="btn wb-btn-orange">
                        {{ $notification->data['btnTxt2'] }}
                    </a>
                @endif
            @endif
        </td>
    @endif
</tr>
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
                    <a href="{{ sprintf('%s?notificationId=%s', $notification->data['btnLink'], $notification->id) }}"
                        class="btn wb-btn-orange custom-btn"
                        data-notifId="{{ $notification->id }}">
                        {{ $notification->data['btnTxt'] }}
                    </a>
                @endif
            </td>
        @endif
    </tr>
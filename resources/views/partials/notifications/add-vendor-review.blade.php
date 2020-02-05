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
        @if (!$notification->read_at)
            <a href="#"
                data-toggle="modal"
                data-notificationid="{{ $notification->id }}"
                data-jobquoteid="{{ $notification->data['jobQuoteId'] }}"
                data-target="#submit-review"
                class="btn wb-btn-orange submit-review">
                {{ $notification->data['btnTxt'] }}
            </a>
        @else
            <a href="#"
                class="btn wb-btn-orange">
                {{ $notification->data['btnTxt'] }}
            </a>
        @endif
    </td>
</tr>
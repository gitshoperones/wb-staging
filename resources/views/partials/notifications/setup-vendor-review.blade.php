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
                data-target="#setup-vendor-review"
                class="btn wb-btn-orange">
                {{ isset($notification->data['btnText']) ? $notification->data['btnText']: 'Get Reviewed' }}
            </a>
        @else
            <a href="#"
                data-toggle="modal"
                data-target="#setup-vendor-review"
                class="btn wb-btn-orange">
                {{ isset($notification->data['btnText']) ? $notification->data['btnText']: 'Get Reviewed' }}
            </a>
        @endif
        <form action="{{ url(sprintf('/dashboard/request-vendor-review?notificationId=%s', $notification->id)) }}" method="POST" id="request-review-form">
            {{ csrf_field() }}
            <input id="c1name" type="hidden" name="couple1_name">
            <input id="c1email" type="hidden" name="couple1_email">
            <input id="c2name" type="hidden" name="couple2_name">
            <input id="c2email" type="hidden" name="couple2_email">
            <input type="hidden" name="notificationId" value="{{ $notification->id }}">
        </form>
    </td>
</tr>
@if ($notification->read_at)
    @include('modals.done-review-invitation')
@else
    @include('modals.review-invitation')
@endif
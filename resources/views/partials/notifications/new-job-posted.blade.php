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
		@if ($notification->data['btnLink'] && $notification->data['btnTxt'])
		@php (strpos($notification->data['btnLink'],'?') !== false) ? $isParam = '&' : $isParam = '?'; @endphp
            <a href="{{ sprintf('%s%snotificationId=%s', $notification->data['btnLink'], $isParam, $notification->id) }}"
                class="btn wb-btn-orange">
                {{ $notification->data['btnTxt'] }}
            </a>
        @endif
	</td>
</tr>
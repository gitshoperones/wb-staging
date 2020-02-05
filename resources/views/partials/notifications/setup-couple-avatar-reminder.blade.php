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
        <a href="#" class="btn wb-btn-orange" id="update-profile-avatar">
            {{ $notification->data['btnTxt'] }}
        </a>
    </td>
</tr>

@push('scripts')
    <script type="text/javascript">
        $('#update-profile-avatar').on('click', function(e) {
            e.preventDefault();
            $('#editImageBtn').trigger('click');
        })
    </script>
@endpush
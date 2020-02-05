<div class="sub-header">
    <ul class="list-inline">
        @if ($jobPost->event->name)
        <li>
            <span class="icon"><i class="fa fa-star-o"></i></span>
            {{ $jobPost->event->name }}
        </li>
        @endif
        <li>
            <span class="icon"><i class="fa fa-calendar"></i></span>
            {{ $jobPost->event_date ?: 'unknown' }}
            @if ($jobPost->is_flexible)
            (this date is flexible)
            @endif
        </li>
        @if ($jobPost->required_address)
        <li>
            <span class="icon"><i class="fa fa-map-marker"></i></span>
            {{ $jobPost->required_address }}
        </li>
        @endif
    </ul>
</div>
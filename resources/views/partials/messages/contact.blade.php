<a href="{{ url(sprintf('dashboard/messages?recipient_user_id=%s', $contact->id)) }}">
    @php
        $isVendorProfile = class_basename($profile) === 'Vendor';
    @endphp

    @if ($profile->profile_avatar)
        <img class="contacts-list-img"
        src="{{ $profile->profile_avatar }}"
        alt="message user image">
    @else
        <img class="contacts-list-img"
            @if ($isVendorProfile)
                src="http://via.placeholder.com/128x128"
            @else
                src="{{ asset('/assets/images/couple-placeholder.jpg') }}"
            @endif
            alt="message user image">
    @endif

    <div class="contacts-list-info">
        <span class="contact-list-name">{{ $profile->title ?: $profile->business_name }}</span>
        {!! (!$read) ? "<span class='contact-list-new-message'>new</span>" : "<span class='contact-last-read'>$read</span>" !!}
        <span class="contact-list-loc">
            {{ $profile->wedding_venue_id ? $profile->weddingVenue->name : ''}}
        </span>
    </div>
</a>
<div class="contact-list-option dropdown d-inline" style="display: inline; vertical-align: middle; ">
    @if ($isVendorProfile)
        <a class="btn btn-light dropdown-toggle"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false" style="color: #fff;">
            <i class="ion ion-more"></i>
        </a>
        <span class="dropdown-menu dropdown-menu-right view-profile">
            <a href="{{ url(sprintf('%s/%s', $type, $profile->id))}}" class="dropdown-item btn" target="_blank">View Profile</a>
        </span>
    @endif
</div>
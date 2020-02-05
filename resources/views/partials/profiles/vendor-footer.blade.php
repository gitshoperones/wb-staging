@if(!Auth::check() || Auth::user()->account == 'couple')
    <div class="vendor-footer">
        <div class="text-center">
            <p class="h2 head">Like {{ $userProfile->business_name }}?</p>
            @couple
                <a href="{{ url(sprintf('dashboard/job-posts/create?vendor_id=%s', $userProfile->id)) }}" class="btn btn-orange">
                    Request Quote
                </a>
            @else
                <a href="{{ '/job-posts/create?vendor_id=' . $userProfile->id }}" class="btn btn-orange request-quote">Request Quote</a>
            @endif
        </div>
    </div>

    @push('css')
    <style>
        .vendor-footer {
            background: #353554;
            color: #ffffff;
            font-family: "Josefin Slab";
            padding: 50px;
        }
        .h2.head {
            margin: 11px 0;
        }
    </style>
    @endpush
@endif
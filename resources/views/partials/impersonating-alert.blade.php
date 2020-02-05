{{-- @if (session('parentImpersonation') && session('parentImpersonation') === true)
    @if(!Request::is("dashboard/*") && !Request::is("dashboard"))
        <div class="attention" style="background-color: #FE5945!important;">
            Managing: {{ Auth::user()->vendorProfile->business_name }}<br/>
            <a href="{{ url('/impersonation/leave') }}" class="btn disable-onclick">
                BACK TO MASTER ACCOUNT
            </a>
        </div>
    @endif
@else
    <div class="attention">
        <p>You are impersonating this account.</p>
        <a href="{{ url('/impersonation/leave') }}" class="btn disable-onclick">
            Leave Impersonation
        </a>
    </div>
@endif --}}

@if (!session('parentImpersonation') && session('parentImpersonation') !== true)
    <div class="attention">
        <p>You are impersonating this account.</p>
        <a href="{{ url('/impersonation/leave') }}" class="btn disable-onclick">
            Leave Impersonation
        </a>
    </div>
@endif

@push('scripts')
<script>
    $('.disable-onclick').click(function() {
        $(this).addClass('disabled')
    });
</script>
@endpush
<h4 class="error-message">
    Please finish the onboarding Process.
    <br />
    <br />
</h4>
@vendor
<a href="{{ url(sprintf('/vendors/%s', Auth::user()->vendorProfile->id)) }}" class="btn wb-btn-orange">
    Finish Onbarding
</a>
@else
<a href="{{ url('/dashboard') }}" class="btn wb-btn-orange">
    Finish Onbarding
</a>
@endvendor

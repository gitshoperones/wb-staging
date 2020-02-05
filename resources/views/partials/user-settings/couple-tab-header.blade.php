@push('css')
<style>
.form-control {
    border: 1px solid #ccd0d2;
    color: #353554;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
    opacity: 1;
}
.wb-box {
    padding: 30px 32px;
    margin-top: 0;
    margin-bottom: 100px;
}
</style>
@endpush

<h1 class="wb-title">Your Settings</h1></div>
<div class="row">
    <div class="text-center user-setting-header">
        <a href="{{ url('/user-settings/account') }}" class="wb-btn-link {{ $setting === 'account' ? 'active' : '' }}">
            ACCOUNT
        </a>
        {{-- <i class="wb-btn-separator"></i>
        <a href="{{ url('/user-settings/payment') }}" class="wb-btn-link {{ $setting === 'payment' ? 'active' : '' }}">
            Payment Methods
        </a> --}}
        <i class="wb-btn-separator"></i>
        <a href="{{ url('/user-settings/notifications') }}" class="wb-btn-link {{ $setting === 'notifications' ? 'active' : '' }}">
            NOTIFICATIONS
        </a>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
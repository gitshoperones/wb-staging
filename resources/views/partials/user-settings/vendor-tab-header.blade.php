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
            BUSINESS DETAILS
        </a>
        <i class="wb-btn-separator"></i>
        <a href="{{ url('/user-settings/users') }}" style="text-transform: none;" class="wb-btn-link {{ $setting === 'users' ? 'active' : '' }}">
            USER & PASSWORD
        </a>
        <i class="wb-btn-separator"></i>
        <a href="{{ url('/user-settings/payment') }}" class="wb-btn-link {{ $setting === 'payment' ? 'active' : '' }}">
            PAYMENT DETAILS  <i class="fa fa-exclamation-circle" title="Why do we need your bank details? This is so that we can deposit payments for your bookings into your account. They are used for no other purpose at any time. When a couple pays your invoice, the money is debited straight into your account via Assembly Payments (our secure payment gateway provider). For any more information on payments, you can contact us at hello@wedbooker.com" data-toggle="tooltip" data-placement="bottom"></i>
        </a>
        <i class="wb-btn-separator"></i>
        <a href="{{ url('/user-settings/notifications') }}" class="wb-btn-link {{ $setting === 'notifications' ? 'active' : '' }}">
            NOTIFICATIONS
        </a>
        <i class="wb-btn-separator"></i>
        <a href="{{ url('/user-settings/terms-and-conditions') }}" style="text-transform: none;" class="wb-btn-link {{ $setting === 'terms-and-conditions' ? 'active' : '' }}">
            YOUR T&Cs
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
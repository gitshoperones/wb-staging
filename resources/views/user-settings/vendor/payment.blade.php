@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
	<div class="container">
		<div class="text-center">
            @include('partials.user-settings.vendor-tab-header')
			<div class="card-account-container">
				<div class="row">
					<div class="wb-box">
						@include('modals.alert-messages')
                        <form method="POST" action="{{ url('vendor-payment-settings') }}" accept-charset="UTF-8">
                            {{ csrf_field() }}
                            <input type="hidden" name="dob" id="user-dob">
							<div class="row">
								<div class="col-md-12">
                                    <div class="form-group" title="Your Legal Business Name *" data-toggle="tooltip">
                                        {{-- <label for="legal_name">Your Legal Business Name <span class="required">*</span></label> --}}
                                        <input value="{{ $loggedInUserProfile->business_name }}"
                                            disabled
                                            placeholder="Your Legal Business Name *"
                                            type="text" id="legal_name" class="form-control">
                                    </div>
                                </div>

                            @impersonating
                                <div class="col-md-6">
                                    <div class="form-group" title="Bank Name *" data-toggle="tooltip">
                                        {{-- <label for="bank_name">Bank Name <span class="required">*</span></label> --}}
                                        <input name="bank"
                                            placeholder="Bank Name *"
                                            value="{{ $paymentSetting->bank }}"
                                            type="text" id="bank_name" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" title="Account Holder Name *" data-toggle="tooltip">
                                        {{-- <label for="account_name">Account Holder Name <span class="required">*</span></label> --}}
                                        <input name="accnt_name"
                                            placeholder="Account Holder Name *"
                                            value="{{ $paymentSetting->accnt_name }}"
                                            type="text" id="account_name" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" title="BSB *" data-toggle="tooltip">
                                        {{-- <label for="bsb">BSB <span class="required">*</span></label> --}}
                                        <input name="bsb"
                                            placeholder="BSB *"
                                            value="{{ $paymentSetting->bsb }}"
                                            type="text" id="bsb" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" title="Account Number *" data-toggle="tooltip">
                                        {{-- <label for="account_number">Account Number <span class="required">*</span></label> --}}
                                        <input name="accnt_num"
                                            placeholder="Account Number *"
                                            value="{{ $paymentSetting->accnt_num }}"
                                            type="text" id="account_number" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3" title="Account Type *" data-toggle="tooltip">
                                    <div class="form-group">
                                        {{-- <label for="bank_account_type">Account Type<span class="required">*</span></label> --}}
                                        <select name="accnt_type" class="form-control" disabled>
                                            <option
                                                @if (old('accnt_type') === 'savings'
                                                    || $paymentSetting->accnt_type === 'savings')
                                                    selected
                                                @endif
                                                value="savings">Savings
                                            </option>
                                            <option
                                                @if (old('accnt_type') === 'checking'
                                                    || $paymentSetting->accnt_type === 'checking')
                                                    selected
                                                @endif
                                                value="checking">Checking
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" title="Holder Type *" data-toggle="tooltip">
                                    <div class="form-group">
                                        {{-- <label for="holder_type">Holder Type<span class="required">*</span></label> --}}
                                        <select name="holder_type" class="form-control" disabled>
                                            <option
                                                @if (old('holder_type') === 'business'
                                                    || $paymentSetting->holder_type === 'business')
                                                    selected
                                                @endif
                                                value="business">Business
                                            </option>
                                            <option
                                                @if (old('holder_type') === 'personal'
                                                    || $paymentSetting->holder_type === 'personal')
                                                    selected
                                                @endif
                                                value="personal">Personal
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" title="Registered for GST? *" data-toggle="tooltip">
                                    <div class="form-group">
                                        {{-- <label for="holder_type">Registered for GST? <span class="required">*</span></label> --}}
                                        <select name="gst_registered" class="form-control" disabled>
                                            <option
                                                @if (old('gst_registered') === 1
                                                    || $loggedInUserProfile->gst_registered === 1)
                                                    selected
                                                @endif
                                                value="1">Yes
                                            </option>
                                            <option
                                                @if (old('gst_registered') === 0
                                                    || $loggedInUserProfile->gst_registered === 0)
                                                    selected
                                                @endif
                                                value="0">No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row mt20">
                                        <div class="col-md-12">
                                            <div class="form-group" title="Date of Birth" data-toggle="tooltip">
                                                {{-- <label class="main"for="">Date of Birth <span class="required">*</span></label> --}}
                                                @php
                                                    if (old('dobM')) {
                                                        $dobM = old('dobM');
                                                    } else {
                                                        $dobM = Auth::user() && Auth::user()->dob ? Auth::user()->dob->format('m') : '';
                                                    }
                                                    if (old('dobD')) {
                                                        $dobD = old('dobD');
                                                    } else {
                                                        $dobD = Auth::user() && Auth::user()->dob ? Auth::user()->dob->format('d') : '';
                                                    }
                                                    if (old('dobY')) {
                                                        $dobY = old('dobY');
                                                    } else {
                                                        $dobY = Auth::user() && Auth::user()->dob ? Auth::user()->dob->format('Y') : '';
                                                    }
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <select id="dob-d" name="birth_day" class="form-control" disabled>
                                                            <option value="">Day</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4" style="padding: 0;">
                                                        <select id="dob-m" name="birth_month" class="form-control" disabled>
                                                            <option value="">Month</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select id="dob-y" name="birth_year" class="form-control" disabled>
                                                            <option value="">Year</option>
                                                            @for($i = now()->subYears(18)->format('Y'); $i >= 1940; $i--)
                                                                <option
                                                                @if ($dobY == $i)
                                                                    selected
                                                                @endif
                                                                value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
									<div class="form-group" title="Bank Name *" data-toggle="tooltip">
										{{-- <label for="bank_name">Bank Name <span class="required">*</span></label> --}}
										<input name="bank"
                                            placeholder="{{ $paymentSetting->bank }}"
                                            type="text" id="bank_name" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" title="Account Holder Name *" data-toggle="tooltip">
										{{-- <label for="account_name">Account Holder Name <span class="required">*</span></label> --}}
										<input name="accnt_name"
                                            placeholder="{{ $paymentSetting->accnt_name }}"
                                            type="text" id="account_name" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" title="BSB *" data-toggle="tooltip">
										{{-- <label for="bsb">BSB <span class="required">*</span></label> --}}
										<input name="bsb"
                                            placeholder="{{  $paymentSetting->bsb }}"
                                            type="text" id="bsb" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" title="Account Number *" data-toggle="tooltip">
										{{-- <label for="account_number">Account Number <span class="required">*</span></label> --}}
										<input name="accnt_num"
                                            placeholder="{{ $paymentSetting->accnt_num }}"
                                            type="text" id="account_number" class="form-control">
									</div>
								</div>
								<div class="col-md-3" title="Account Type *" data-toggle="tooltip">
									<div class="form-group">
                                        {{-- <label for="bank_account_type">Account Type<span class="required">*</span></label> --}}
										<select name="accnt_type" class="form-control">
											<option
                                                @if (old('accnt_type') === 'savings'
                                                    || $paymentSetting->accnt_type === 'savings')
                                                    selected
                                                @endif
                                                value="savings">Savings
                                            </option>
											<option
                                                @if (old('accnt_type') === 'checking'
                                                    || $paymentSetting->accnt_type === 'checking')
                                                    selected
                                                @endif
                                                value="checking">Checking
                                            </option>
										</select>
									</div>
								</div>
                                <div class="col-md-3" title="Holder Type *" data-toggle="tooltip">
                                    <div class="form-group">
                                        {{-- <label for="holder_type">Holder Type<span class="required">*</span></label> --}}
                                        <select name="holder_type" class="form-control">
                                            <option
                                                @if (old('holder_type') === 'business'
                                                    || $paymentSetting->holder_type === 'business')
                                                    selected
                                                @endif
                                                value="business">Business
                                            </option>
                                            <option
                                                @if (old('holder_type') === 'personal'
                                                    || $paymentSetting->holder_type === 'personal')
                                                    selected
                                                @endif
                                                value="personal">Personal
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" title="Registered for GST? *" data-toggle="tooltip">
                                    <div class="form-group">
                                        {{-- <label for="holder_type">Registered for GST? <span class="required">*</span></label> --}}
                                        <select name="gst_registered" class="form-control">
                                            <option
                                                @if (old('gst_registered') === 1
                                                    || $loggedInUserProfile->gst_registered === 1)
                                                    selected
                                                @endif
                                                value="1">Yes
                                            </option>
                                            <option
                                                @if (old('gst_registered') === 0
                                                    || $loggedInUserProfile->gst_registered === 0)
                                                    selected
                                                @endif
                                                value="0">No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row mt20">
                                        <div class="col-md-12">
                                            <div class="form-group" title="Date of Birth" data-toggle="tooltip">
                                                {{-- <label class="main"for="">Date of Birth <span class="required">*</span></label> --}}
                                                @php
                                                    if (old('dobM')) {
                                                        $dobM = old('dobM');
                                                    } else {
                                                        $dobM = Auth::user() && Auth::user()->dob ? Auth::user()->dob->format('m') : '';
                                                    }
                                                    if (old('dobD')) {
                                                        $dobD = old('dobD');
                                                    } else {
                                                        $dobD = Auth::user() && Auth::user()->dob ? Auth::user()->dob->format('d') : '';
                                                    }
                                                    if (old('dobY')) {
                                                        $dobY = old('dobY');
                                                    } else {
                                                        $dobY = Auth::user() && Auth::user()->dob ? Auth::user()->dob->format('Y') : '';
                                                    }
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <select id="dob-d" name="birth_day" class="form-control">
                                                            <option value="">Day </option>
                                                            @for($i = 1; $i < 32; $i++)
                                                                <option
                                                                @if ($dobD == $i)
                                                                    selected
                                                                @endif
                                                                value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4" style="padding: 0;">
                                                        <select id="dob-m" name="birth_month" class="form-control">
                                                            <option value="">Month </option>
                                                            @for($i = 1; $i < 13; $i++)
                                                                <option
                                                                @if ($dobM == $i)
                                                                    selected
                                                                @endif
                                                                value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select id="dob-y" name="birth_year" class="form-control">
                                                            <option value="">Year </option>
                                                            @for($i = now()->subYears(18)->format('Y'); $i >= 1940; $i--)
                                                                <option
                                                                @if ($dobY == $i)
                                                                    selected
                                                                @endif
                                                                value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endImpersonating
							</div>

							<h4 class="title">Registered Business Address</h4>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" title="PO BOX or Street Address *" data-toggle="tooltip">
										{{-- <label for="account_address">PO BOX or Street Address <span class="required">*</span></label> --}}
                                        <input name="street"
                                            placeholder="PO BOX or Street Address *"
                                            value="{{ old('street') ?: $loggedInUserProfile->street }}"
                                            type="text" id="account_address" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group" title="City *" data-toggle="tooltip">
										{{-- <label for="account_city">City <span class="required">*</span></label> --}}
                                        <input name="city"
                                            placeholder="City *"
                                            value="{{ old('city') ?: $loggedInUserProfile->city }}"
                                            type="text" id="account_city" class="form-control">
									</div>
								</div>
								<div class="col-md-3" title="State *" data-toggle="tooltip">
                                    {{-- <label for="state">State <span class="required">*</span></label> --}}
                                    <select name="state" class="form-control">
                                        @foreach($states as $key => $state)
                                        <option
                                            @if (old('state') === $key
                                                || $loggedInUserProfile->state  === $key)
                                                selected
                                            @endif
                                            value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
								</div>
								<div class="col-md-3" title="Country *" data-toggle="tooltip">
                                    {{-- <label for="Country">Country <span class="required">*</span></label> --}}
									<select name="country" class="form-control" disabled>
										<option value="Australia">Australia</option>
									</select>
								</div>
								<div class="col-md-2" title="Postcode *" data-toggle="tooltip">
                                    {{-- <label for="postcode">Postcode <span class="required">*</span></label> --}}
                                    <input name="postcode"
                                    placeholder="Postcode *"
                                        value="{{ old('postcode') ?: $loggedInUserProfile->postcode }}"
                                        type="text" id="postcode" class="form-control">
								</div>
							</div><!-- /.row -->
							<input type="submit" id="submit-payment-setting" value="SAVE CHANGES" class="btn wb-btn-orange">
						</form>
					</div>
				</div>
			</div>
        </div>
	</div>
</section>
<div class="modal fade" id="processing" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div id="wb-modal-success" class="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-body ">
                    <p>
                        Processing your request... Please wait!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#submit-payment-setting').on('click', function() {
                var dobD = $('#dob-d').val();
                var dobM = $('#dob-m').val();
                var dobY = $('#dob-y').val();
                var dob = dobY+'-'+dobM+'-'+dobD;
                $('#user-dob').val(dob);
                $('#processing').modal('show');
            });
        })
    </script>
@endpush
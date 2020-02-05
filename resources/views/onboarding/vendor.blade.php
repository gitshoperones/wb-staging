<form action="{{ url('vendor-onboarding') }}" method="POST" id="onboarding-form">
	{{ csrf_field() }}
	<input id="fname" type="hidden" name="fname">
	<input id="lname" type="hidden" name="lname">
	<input id="phone_number" type="hidden" name="phone_number">
	<input id="reviewer1name" type="hidden" name="couple1_name">
	<input id="reviewer1email" type="hidden" name="couple1_email">
	<input id="reviewer2name" type="hidden" name="couple2_name">
	<input id="reviewer2email" type="hidden" name="couple2_email">
    <input type="hidden" name="country" value="Australia">
	<input type="hidden" id="my-email" value="{{ Auth::user()->email }}">
	<!-- Onboarding Modal -->
	<div class="modal fade onboarding-wrapper vendor bigimage" id="onboarding-vendor" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
		<div id="wb-modal-vendor" class="modal-dialog">
			<div class="modal-dialog">
				<div class="icon-wrappers onboarding vendor">
					<img src="{{ ($result = $pageSettings->firstWhere('meta_key', 'vendor_icon')) ? Storage::url($result->meta_value) : asset('/assets/images/wedbooker-white-icon.png') }}" alt="">
				</div>
				<div class="modal-content text-center welcome" style="background-image: url({{ ($result = $pageSettings->firstWhere('meta_key', 'vendor_bg')) ? Storage::url($result->meta_value) : asset('/assets/images/bg-onboard-couple.jpg') }})">
					<div class="modal-body">
						<h2 class="title">{!! $pageSettings->firstWhere('meta_key', 'vendor_title')->meta_value ?? 'welcome to wedbooker' !!}</h2>
						<div class="desc">{!! $pageSettings->firstWhere('meta_key', 'vendor_description')->meta_value ?? 'Complete your application. It will only take 5 minutes' !!}</div>
						<a id="step-1" href="#"
						data-toggle="modal"
						data-target="#onboarding-business-details"
						class="step1 wb-btn wb-btn-lg wb-btn-orange">
						{!! $pageSettings->firstWhere('meta_key', 'vendor_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'vendor_button')->meta_value) : 'get started' !!}
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Onboarding Modal -->
<div class="modal fade onboarding-wrapper vendor step4b" id="onboarding-business-details" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
	<div id="wb-modal-vendor4b" class="modal-dialog">
		<div class="modal-dialog">
			<div class="icon-wrappers onboarding vendor">
				<img clas="check" src="{{ asset('assets/images/icon-check.png') }}" alt="">
			</div>
			<div class="modal-content text-center">
				<div class="modal-body">
					<div class="desc wide">
						<div class="row mt20">
							<div class="col-md-12">
								<div class="form-group">
									<br />
									<h2 class="title wide medium" style="margin: 10px 0;">Enter your business details</h2>
									<input id="vendor-bussinessname" type="text" name="business_name" value="" required="required" class="form-control" placeholder="Business Name (The name we will show on your profile) *">
								</div>
							</div>
						</div>
						<div class="row mt20">
							<div class="col-md-12">
								<div class="form-group">
									<input id="vendor-abn" type="text" name="abn" class="form-control" placeholder="ABN">
								</div>
							</div>
						</div>
						<div class="row mt20">
							<div class="col-md-12">
								<div class="form-group">
									<input id="vendor-website" type="text" name="website" value="" required="required" class="form-control" placeholder="Business website *">
									<small><i>If you don't have a website, please enter your business Facebook or Instagram URL.</i></small>
								</div>
							</div>
						</div>
					</div>
					<div class="actions">
						<a href="#" data-toggle="modal"
						data-target="#onboarding-vendor"
						class="btn-fixed-1-2 step2 wb-btn wb-btn-lg wb-btn-gray back">
						go back
					</a>
					<a id="step-2" href="#"
					class="btn-fixed-2-1 step2 wb-btn wb-btn-lg wb-btn-orange">
					NEXT - 3 STEPS LEFT
				</a>
			</div><!-- /.actions -->
		</div>
	</div>
</div>
</div>
</div>

<!-- Onboarding Modal -->
<div class="modal fade onboarding-wrapper vendor step4c" id="onboarding-business-address" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
	<div id="wb-modal-vendor4c" class="modal-dialog">
		<div class="modal-dialog">
			<div class="icon-wrappers onboarding vendor">
				<img clas="check" src="{{ asset('assets/images/icon-check.png') }}" alt="">
			</div>
			<div class="modal-content text-center">
				<div class="modal-body">
					<div class="desc wide">
						<br />
						<h2 class="title wide medium" style="margin: 10px 0;">Registered Business Address</h2>
						<div class="row mt20">
							<div class="col-md-6">
								<div class="form-group">
									<input id="street"
									name="street"
									type="text"
									class="form-control"
									placeholder="PO Box or Street Address">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input id="city"
									name="city"
									type="text"
									class="form-control"
									placeholder="City">
								</div>
							</div>
						</div>
					</div>
					<div class="row mt20">
						<div class="col-md-6">
							<div class="form-group">
								<select name="state" class="form-control">
									@foreach($states as $key => $state)
									<option value="{{ $key }}">{{ $state }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input id="postcode"
								name="postcode"
								type="text"
								class="form-control"
								placeholder="Postcode">
							</div>
						</div>
					</div>
				</div>
				<div class="actions">
					<a href="#" data-toggle="modal"
					data-target="#onboarding-business-details"
					class="btn-fixed-1-2 step2 wb-btn wb-btn-lg wb-btn-gray back">
					go back
				</a>
				<a id="step-2b" href="#"
				class="btn-fixed-2-1 step2 wb-btn wb-btn-lg wb-btn-orange">
				NEXT - 2 STEPS LEFT
			</a>
		</div><!-- /.actions -->
	</div>
</div>
</div>
</div>
</div>
<!-- Onboarding Modal -->
<div class="modal fade onboarding-wrapper vendor step4d" id="onboarding-contact-info" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
	<div id="wb-modal-vendor4d" class="modal-dialog">
		<div class="modal-dialog">
			<div class="icon-wrappers onboarding vendor">
				<i class="fa fa-phone"></i>
			</div>
			<div class="modal-content text-center">
				<div class="modal-body">
					<div class="desc wide">
						<h2 class="title wide medium" style="text-align: center;">Primary User Details</h2>
						<div class="row mt20">
							<div class="col-md-6">
								<div class="form-group">
									<input id="vendor-fname" type="text" name="fName" class="form-control" placeholder="First Name *">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input id="vendor-lname" type="text" name="lName" class="form-control" placeholder="Last Name *">
								</div>
							</div>
						</div>
						<div class="row mt20">
							<div class="col-md-6">
								<div class="form-group">
									<input id="vendor-phonenumber" name="phoneNumber" type="text" class="form-control" placeholder="Phone Number *">
								</div>
							</div>
						</div>
					</div>
					<div class="actions">
						<a href="#" data-toggle="modal"
						data-target="#onboarding-business-address"
						class="btn-fixed-1-2 step2 wb-btn wb-btn-lg wb-btn-gray back">
						go back
					</a>
					<a id="step-3" href="#"
					data-target="#onboarding-business-address"
					class="btn-fixed-2-1 step2 wb-btn wb-btn-lg wb-btn-orange">
					NEXT - FINISH
				</a>
			</div><!-- /.actions -->
		</div>
	</div>
</div>
</div>
</div>
<!-- Onboarding Modal -->
<div class="modal fade onboarding-wrapper vendor step4b" id="onboarding-business-review" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
	<div id="wb-modal-vendor4b" class="modal-dialog">
		<div class="modal-dialog">
			<div class="icon-wrappers onboarding vendor">
				<img clas="check" src="{{ asset('assets/images/icon-check.png') }}" alt="">
			</div>
			<div class="modal-content text-center">
				<div class="modal-body">
					<div class="desc wide">
						<div class="row mt20">
							<p>Couple 1</p>
							<div class="col-md-6">
								<div class="form-group">
									<input id="couple-reviewer-name1" type="text" name="couple1_name" class="form-control" placeholder="Full Name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input id="couple-reviewer-email1" type="text" name="couple1_email" class="form-control" placeholder="Email">
								</div>
							</div>
						</div>
						<div class="row mt20">
							<p>Couple 2</p>
							<div class="col-md-6">
								<div class="form-group">
									<input id="couple-reviewer-name2" type="text" name="couple2_name" class="form-control" placeholder="Full Name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input id="couple-reviewer-email2" type="text" name="couple2_email" class="form-control" placeholder="Email">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input id="agree-review-terms" type="checkbox" name="agree-review-terms" class="form-control">
									<label for="agree-review-terms" class="form-control">
										I agree and confirm that these are true Couples who have utilised my wedding services and agree to wedBooker sending an email to these Couples to seek a Review of your wedding services for inclusion in your wedBooker profile.
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="actions">
						<a href="#" data-toggle="modal"
						data-target="#onboarding-business-address"
						class="btn-fixed-1-2 step2 wb-btn wb-btn-lg wb-btn-gray back">
						go back
					</a>
					<a id="step-4" href="#"
					class="btn-fixed-2-1 step2 wb-btn wb-btn-lg wb-btn-orange">
					NEXT - FINISH
				</a>
                <br /><br /><br />
			</div><!-- /.actions -->
		</div>
	</div>
</div>
</div>
</div>

<!-- Onboarding Modal -->
<div class="modal fade onboarding-wrapper vendor bigimage" id="onboarding-final-step" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
	<div id="wb-modal-vendor5" class="modal-dialog">
		<div class="modal-dialog">
			<div class="icon-wrappers onboarding vendor">
				<img clas="check" src="{{ ($result = $pageSettings->firstWhere('meta_key', 'vendor_icon_last')) ? Storage::url($result->meta_value) : asset('/assets/images/icon-check.png') }}" alt="">
			</div>
			<div class="modal-content text-center finish" style="background-image: url({{ ($result = $pageSettings->firstWhere('meta_key', 'vendor_bg_last')) ? Storage::url($result->meta_value) : asset('/assets/images/bg-onboard-couple2.jpg') }})">
				<div class="modal-body">
					<h2 class="title" style="color: #353554;">{!! $pageSettings->firstWhere('meta_key', 'vendor_title_last')->meta_value ?? 'Let\'s Do This!' !!}</h2>
					<div class="desc">{!! $pageSettings->firstWhere('meta_key', 'vendor_description_last')->meta_value ?? 'It\'s time setup your profile so we can advertise your business to couples.' !!}</div>
					<a id="submit-onboarding" href="#" class="finish wb-btn wb-btn-lg wb-btn-orange">{!! $pageSettings->firstWhere('meta_key', 'vendor_button_last') ? strip_tags($pageSettings->firstWhere('meta_key', 'vendor_button_last')->meta_value) : 'Setup My Profile Now' !!}</a>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
@push('scripts')
<script type="text/javascript">
	var previousModal = null
	var msg = '';

	$(document).ready(function(){
		$('#onboarding-vendor').modal('show');
	})

	$('#submit-onboarding').on('click', function(){
		$('#onboarding-form').submit();
	})

	$('.back').on('click', function(e){
		e.preventDefault();
		$(this).closest('.onboarding-wrapper').modal('hide');
	})

	$('#step-1').on('click', function(e){
		e.preventDefault();
		$(this).closest('.onboarding-wrapper').modal('hide');
	});

	$('#step-2').on('click', function(e){
		e.preventDefault();

		var businessName = $('#vendor-bussinessname').val();
		if (!businessName) {
			msg = 'Please enter your business name.';
			showAlertMessage();
			return false;
		}
		var website = $('#vendor-website').val();
		if (!website) {
			msg = 'Please enter your business website.';
			showAlertMessage();
			return false;
		}

		$('#onboarding-business-address').modal('show');
		$(this).closest('.onboarding-wrapper').modal('hide');
	})

	$('#step-2b').on('click', function(e){
		e.preventDefault();

		var streetAdd = $('#street').val();
		if (!streetAdd) {
			msg = 'Please enter your PO Box or Street Address.';
			showAlertMessage();
			return false;
		}

		var city = $('#city').val();
		if (!city) {
			msg = 'Please enter your city.';
			showAlertMessage();
			return false;
		}

		var postcode = $('#postcode').val();
		if (!postcode || postcode.length !== 4 || !/^[0-9]+$/.test(postcode)) {
			msg = 'Please enter correct 4 digit Postcode';
			showAlertMessage();
			return false;
		}

		$('#onboarding-contact-info').modal('show');
		$(this).closest('.onboarding-wrapper').modal('hide');
	})

	$('#step-3').on('click', function(e){
		e.preventDefault();

		var fname = $('#vendor-fname').val();
		$('#fname').val(fname);
		if (!fname) {
			msg = 'Please enter your contact firstname.';
			showAlertMessage();
			return false;
		}

		var lname = $('#vendor-lname').val();
		$('#lname').val(lname);
		if (!lname) {
			msg = 'Please enter your contact lastname.';
			showAlertMessage();
			return false;
		}

		var phoneNumber = $('#vendor-phonenumber').val();
		$('#phone_number').val(phoneNumber);
		if (!phoneNumber) {
			msg = 'Please enter your phone number.';
			showAlertMessage();
			return false;
		}

		// $('#onboarding-business-review').modal('show');
		$('#onboarding-final-step').modal('show');
		$(this).closest('.onboarding-wrapper').modal('hide');
	})

	$('#step-4').on('click', function(e) {
		e.preventDefault();

		var couple1Email = $('#couple-reviewer-email1').val();
		$('#reviewer1email').val(couple1Email);
		var couple1Name = $('#couple-reviewer-name1').val();
		$('#reviewer1name').val(couple1Name);
		var couple2Email = $('#couple-reviewer-email2').val();
		$('#reviewer2email').val(couple2Email);
		var couple2Name = $('#couple-reviewer-name2').val();
		$('#reviewer2name').val(couple2Name);

		if (couple1Email && !validateEmail(couple1Email)) {
            msg = 'Please enter valid couple 1 email.';
            showAlertMessage();
            return false;
        }

        var myEmail = $('#my-email').val();

        if (couple1Email === myEmail || couple2Email === myEmail) {
			msg = 'You can\'t invite your own email.';
			showAlertMessage();
			return false;
		}

		if (couple1Email && !couple1Name) {
			msg = 'Please enter couple 1 full name.';
			showAlertMessage();
			return false;
		}

		if (couple2Email && !validateEmail(couple2Email)) {
			msg = 'Please enter valid couple 2 email.';
			showAlertMessage();
			return false;
		}

		if (couple2Email && !couple2Name) {
			msg = 'Please enter couple 2 full name.';
			showAlertMessage();
			return false;
		}

		if ((couple2Email || couple1Email) && couple2Email === couple1Email) {
			msg = 'Please enter unique couple 2 email.';
			showAlertMessage();
			return false;
		}

		if ((couple1Email || couple2Email) && !$('#agree-review-terms').prop('checked')) {
			msg = 'Please accept the Terms & Conditions to proceed.';
			showAlertMessage();
			return false;
		}

		$('#onboarding-final-step').modal('show');
		$(this).closest('.onboarding-wrapper').modal('hide');
	});

	function mustBe18YearsAndAbove(year, month, day) {
		var age = 18;
		var mydate = new Date();
		mydate.setFullYear(year, month-1, day);

		var currdate = new Date();
		currdate.setFullYear(currdate.getFullYear() - age);
		if ((currdate - mydate) < 0){
			return false;
		}
		return true;
	}

    function showAlertMessage() {
        swal({
            type: 'error',
            title: msg,
            text: '',
        })
    }

	function invalidNumber(val) {
		var regex=/^[0-9]+$/;
		if (!val.match(regex)) {
			return true;
		}
		return false;
	}

	function validateEmail(email) {
		var re = /\S+@\S+\.\S+/;
		return re.test(email);
	}
</script>
@endpush
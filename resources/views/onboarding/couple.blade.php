@push('css')
<style>
	.multiSel span {
		color: #353554!important;
		font-weight: 400!important;
	}
	.mutliSelect label {
		width: 100%;
	}

	.modal-body {
		overflow-x: hidden;
	}
</style>
@endpush

<form action="{{ url('couple-onboarding') }}" method="POST" id="onboarding-form">
	{{ csrf_field() }}
	<input type="hidden" name="onboarding" value="1">
	<input type="hidden" id="my-own-email" value="{{ Auth::user()->email }}">
	{{-- <input id="dob" type="hidden" name="dob"> --}}
	<!-- Onboarding Modal -->
	<div class="modal fade onboarding-wrapper couple bigimage" id="onboarding-couple1" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="" aria-hidden="true">
		<div id="wb-modal-couple" class="modal-dialog">
			<div class="modal-dialog">
				<div class="icon-wrappers onboarding couple">
				<img src="{{ ($result = $pageSettings->firstWhere('meta_key', 'couple_icon')) ? Storage::url($result->meta_value) : asset('/assets/images/wedbooker-white-icon.png') }}" alt="">
				</div>
				<div class="modal-content text-center welcome" style="background-image: url({{ ($result = $pageSettings->firstWhere('meta_key', 'couple_bg')) ? Storage::url($result->meta_value) : asset('/assets/images/bg-onboard-couple.jpg') }})">
					<div class="modal-body">
						<h2 class="title">{!! $pageSettings->firstWhere('meta_key', 'couple_title')->meta_value ?? 'welcome to wedbooker' !!}</h2>
						<div class="desc">{!! $pageSettings->firstWhere('meta_key', 'couple_description')->meta_value ?? 'Your one-stop-shop for booking wedding suppliers and venues.' !!}</div>
						<br /><br />
						<a href="#"
							data-toggle="modal"
							data-target="#onboarding-couple2"
							class="step1 wb-btn wb-btn-lg wb-btn-orange">
							{!! $pageSettings->firstWhere('meta_key', 'couple_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'couple_button')->meta_value) : 'get started' !!}
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Onboarding Modal -->
	<div class="modal fade onboarding-wrapper couple step3" id="onboarding-couple2" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
		<div id="wb-modal-couple3" class="modal-dialog">
			<div class="modal-dialog">
				<div class="icon-wrappers onboarding couple">
					<i class="fa fa-envelope"></i>
				</div>
				<div class="modal-content text-center">
					<div class="modal-body">
						<h2 class="title">CONTACT DETAILS</h2>
						<div class="desc wide">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label  for="">First name</label>
										<input type="text" id="userAFname" name="userA_fname" value="{{ old('userA_fname') }}" required="required" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Surname</label>
										<input type="text" id="userALname" name="userA_lname" value="{{ old('userA_lname') }}" required="required" class="form-control">
									</div>
								</div>
								<div class="col-md-3"></div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Phone Number</label>
										<input type="number" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required="required" class="form-control">
									</div>
								</div>
							</div>
							{{-- <div class="row">
								<label class="main"for="">Date of Birth</label>
								<div class="col-md-12">
									<div data-provide="datepicker"
										data-date-format="yyyy-mm-dd"
										data-date-end-date="-18y"
										class="wb-form-group input-group date text-center">
										<input id="dob"
										type="text"
										onkeydown="return false"
										name="dob"
										class="form-control"
										style="text-align: center;">
										<div class="input-group-addon" style="border: 0;">
											<span class="fa fa-calendar"></span>
										</div>
									</div>
								</div> --}}
								{{-- <div class="col-md-4">
									<div class="form-group">
										<label for="">Day</label>
										<select class="form-control" id="dob-d">
											<option value="">Select</option>
											@for($i = 1; $i < 32; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Month</label>
										<select class="form-control" id="dob-m">
											<option value="">Select</option>
											@for($i = 1; $i < 13; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Year</label>
										<select class="form-control" id="dob-y">
											<option value="">Select</option>
											@for($i = now()->subYears(18)->format('Y'); $i >= 1940; $i--)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
									</div>
								</div> --}}
							{{-- </div> --}}
						</div>
						<br /><br />
						<a href="#"
							id="couple-details"
							data-toggle="modal"
							data-target="#onboarding-couple3"
							class="step2 wb-btn wb-btn-lg wb-btn-orange">
							NEXT
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Onboarding Modal -->
	<div class="modal fade onboarding-wrapper couple step4" id="onboarding-couple3" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
		<div id="wb-modal-couple4" class="modal-dialog">
			<div class="modal-dialog">
				<div class="icon-wrappers onboarding couple">
					<i class="fa fa-envelope"></i>
				</div>
				<div class="modal-content text-center">
					<div class="modal-body">
						<h2 class="title">YOUR PARTNER</h2>
						<div class="desc wide">
							<div class="row">
							<br />
								<div class="col-md-6">
									<div class="form-group">
										<label  for="">Partner's First Name</label>
										<input type="text" id="userBFname" name="userB_fname" value="{{ old('userB_fname') }}" required="required" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Partner's Surname</label>
										<input type="text" id="userBLname" name="userB_lname" value="{{ old('userB_lname') }}" required="required" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<br /><br />
						<a href="#"
							data-toggle="modal"
							data-target="#onboarding-couple2"
							class="step2 wb-btn wb-btn-lg wb-btn-gray">
							go back
						</a>
						<a href="#"
							id="couple-details2"
							data-toggle="modal"
							data-target="#onboarding-couple3a"
							class="step2 wb-btn wb-btn-lg wb-btn-orange">
							NEXT
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Onboarding Modal -->
	<div class="modal fade onboarding-wrapper couple step3a" id="onboarding-couple3a" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
		<div id="wb-modal-couple4" class="modal-dialog">
			<div class="modal-dialog">
				<div class="icon-wrappers onboarding couple">
					<img src="{{ asset('assets/images/wedbooker-white-icon.png') }}">
				</div>
				<div class="modal-content text-center">
					<div class="modal-body">
						<h2 class="title" style="max-width: unset;">TELL US A LITTLE MORE...</h2>
						<div class="desc wide">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label  for="">Which event can we help with?</label>
										<select name="event_id" class="form-control">
											<option value=""></option>
											@foreach($eventTypes as $event)
											<option value="{{ $event->id }}"
												@if (isset($jobPost) && $jobPost->event_id == $event->id)
												selected
												@elseif (old('event_id') == $event->id)
												selected
												@endif
												>
												{{ $event->name }}
											</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Event date (if known)</label>
										<div data-provide="datepicker"
											data-date-format="dd/mm/yyyy"
											data-date-start-date="+1d"
											class="wb-form-group input-group date text-center"
											style="">
											<input id="jobDate"
											type="text"
											onkeydown="return false"
											name="event_date"
											class="form-control"
											style="text-align: center;">
										<div class="input-group-addon" style="border-top: 0; border-right: 0;">
											<span class="fa fa-calendar"></span>
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="">What services are you looking for?</label>
										<dl class="selectdropdown" style="width: 100%;">
											<dt style="max-width: 600px; margin: auto;">
												<a href="#" style="text-align: center; border-bottom: none;">
													<span class="btn wb-btn-orange mini" style="color: rgb(255, 255, 255);">Select Services</span>
												</a>
												<p class="multiSel" style="text-align: center;"></p>
											</dt>
											<dd style="max-width: 600px; margin: auto;">
												<div class="mutliSelect">
													<ul class="" style="border-right: 1px solid #ccd0d2; position: relative;">
														@foreach($categories as $category)
														<li>
															<input type="checkbox" id="exp{{ $category->id }}" name="categories[]" class="vendor-expertise" value="{{ $category->name }}">
															<label for="exp{{ $category->id }}">{{ $category->name }}</label>
														</li>
														@endforeach
													</ul>
												</div>
											</dd>
										</dl>
									</div>
								</div>
							</div>
						</div>
						<a href="#"
							data-toggle="modal"
							data-target="#onboarding-couple3"
							class="step2 wb-btn wb-btn-lg wb-btn-gray">
							go back
						</a>
						<a href="#"
							id="couple-details2a"
							data-toggle="modal"
							data-target="#onboarding-couple4"
							class="step2 wb-btn wb-btn-lg wb-btn-orange">
							NEXT
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Onboarding Modal -->
	<div class="modal fade onboarding-wrapper couple bigimage" id="onboarding-couple4" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
		<div id="wb-modal-couple5" class="modal-dialog">
			<div class="modal-dialog">
				<div class="icon-wrappers onboarding couple">
				<img clas="check" src="{{ ($result = $pageSettings->firstWhere('meta_key', 'couple_icon_last')) ? Storage::url($result->meta_value) : asset('/assets/images/icon-check.png') }}" alt="">
				</div>
				<div class="modal-content text-center finish" style="background-image: url({{ ($result = $pageSettings->firstWhere('meta_key', 'couple_bg_last')) ? Storage::url($result->meta_value) : asset('/assets/images/bg-onboard-couple2.jpg') }})">
					<div class="modal-body">
						<h2 class="title" style="color: #373554;">{!! $pageSettings->firstWhere('meta_key', 'couple_title_last')->meta_value ?? 'YOU\'RE READY TO GO!' !!}</h2>
						<div class="desc">{!! $pageSettings->firstWhere('meta_key', 'couple_description_last')->meta_value ?? 'We will now take you to your planning dashboard where you can manage your quotes, bookings and payments.' !!}</div>
						<br /><br />
						<a href="#"
							data-toggle="modal"
							data-target="#onboarding-couple3a"
							class="step2 wb-btn wb-btn-lg wb-btn-gray">
							go back
						</a>
						<a href="#"
							id="submit-onboarding"
							class="finish wb-btn wb-btn-lg wb-btn-orange">
							{!! $pageSettings->firstWhere('meta_key', 'couple_button_last') ? strip_tags($pageSettings->firstWhere('meta_key', 'couple_button_last')->meta_value) : 'LET\'S DO THIS' !!}
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@push('scripts')
<script type="text/javascript">
	var previousModal = null;
	var msg = '';
	var elId = '';

	$('dt a, dt span.btn.mini').click(function() {
		$('dd ul').toggleClass('show');
		return false;
	});

	$('.mutliSelect input[type="checkbox"]').on('click', function() {
		$('dd ul').toggleClass('show');
	});

	$('#onboarding-couple1').modal('show');

	$('.wb-btn').on('click', function(e) {
		elId = $(this).attr('id');

		if (elId === 'couple-details') {
			if (validateCouple1() == false) {
				showAlertMessage();
				return false;
			}
		} else if (elId === 'couple-details2') {
			if (validateCouple2() == false) {
				showAlertMessage();
				return false;
			}
		}

		$(this).closest('.onboarding-wrapper').modal('hide');
	});

	function validateCouple1() {
		if (!$('#userAFname').val()) {
			msg = 'Please add your firstname.';
			return false;
		}

		if (!$('#userALname').val()) {
			msg = 'Please add your surname.';
			return false;
		}

		if (!$('#phone_number').val()) {
			msg = 'Please add your phone number.';
			return false;
		}

		// var dobD = $('#dob-d').val();
		// if (!dobD || dobD > 31 || invalidNumber(dobD) || dobD > 31) {
		// 	msg = 'Invalid Birth Day';
		// 	return false;
		// }
		// var dobM = $('#dob-m').val();
		// if (!dobM || dobM > 12 || invalidNumber(dobM) || dobM > 12) {
		// 	msg = 'Invalid Birth Month';
		// 	return false;
		// }
		// var dobY = $('#dob-y').val();
		// if (!dobY || dobY.length !== 4 || invalidNumber(dobY)) {
		// 	msg = 'Invalid Birth Year';
		// 	return false;
		// }

		// if (!mustBe18YearsAndAbove(dobY, dobM, dobD)) {
		// 	msg = 'You must be over 18 years old';
		// 	return false;
		// }

		// var dob = dobY+'-'+dobM+'-'+dobD;
		// $('#dob').val(dob);
		// if (!dob) {
		// 	msg = 'Please enter your date of birth.';
		// 	return false;
		// }
		
		// var dob = $('#dob').val();
		// if (!dob) {
		// 	msg = 'Please enter your date of birth.';
		// 	return false;
		// }

		return true;
	}

	function validateCouple2() {
		if (!$('#userBFname').val()) {
			msg = 'Please add your partner\'s firstname.';
			return false;
		}

		if (!$('#userBLname').val()) {
			msg = 'Please add your partner\'s surname.';
			return false;
		}
	}

	// function mustBe18YearsAndAbove(year, month, day) {
	// 	var age = 18;
	// 	var mydate = new Date();
	// 	mydate.setFullYear(year, month-1, day);

	// 	var currdate = new Date();
	// 	currdate.setFullYear(currdate.getFullYear() - age);
	// 	if ((currdate - mydate) < 0){
	// 		return false;
	// 	}
	// 	return true;
	// }

	function showAlertMessage() {
		swal({
			type: 'error',
			title: msg,
			text: '',
		})
	}

	function validateEmail(email) {
		var re = /\S+@\S+\.\S+/;
		return re.test(email);
	}

	function invalidNumber(val) {
		var regex=/^[0-9]+$/;
		if (!val.match(regex)) {
			return true;
		}
		return false;
	}

	$('#submit-onboarding').on('click', function(){
		$('#onboarding-form').submit();
	})
</script>
@endpush
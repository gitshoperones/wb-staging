@extends('layouts.dashboard')

@push('css')
<link href="{{ asset('assets/js/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
<style>
	.selectdropdown dt a {
		border: 1px solid #ccd0d2;
	}
	dl.selectdropdown {
		margin-bottom: 0;
	}
	.form-control::-moz-placeholder {
		color: #353554;
		opacity: 1;
	}
	.form-control:-ms-input-placeholder {
		color: #353554;
	}
	.form-control::-webkit-input-placeholder {
		color: #353554;
	}
</style>
@endpush

@section('content')
	<section class="wb-bg-grey section-postJob content" style="padding: 40px 0px">
		<div class="container-fluid">
			<div class="wb-tab-job">
				<form action="{{ url(sprintf('/dashboard/job-posts/%s', $jobPost->id)) }}"
					method="POST"
					enctype="multipart/form-data"
                    autocomplete="off" id="job-post-form">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="PATCH">
					@include('partials.alert-messages')
					@include('partials.job-posts.steps-label')
					<div class="tab-content job-post-tabs">
						@include('partials.job-posts.step-1-form')
						@include('partials.job-posts.step-2-form')
						@include('partials.job-posts.step-3-form')
						@include('partials.job-posts.step-4-form', array('btnLbl' => 'Update Job Post'))
					</div>
				</form>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/bootstrap-wysiwyg/external/jquery.hotkeys.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/bootstrap-wysiwyg/bootstrap-wysiwyg.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
<script type="text/javascript">
	$('#job-post-form').submit(function() {
		$('button[type="submit"]').addClass('disabled');
		$('button[type="submit"]').css('pointer-events', 'none');
	});

	$('.template').hide();

    var category = $('#job_category_id').children('option:selected').val();

    $('#job_category_id').change(function(){
        $('.template').hide();
        category = $(this).children('option:selected').val();
        $('#template').html('');
        $('.template-1-title').show();
        $('.template').show();
        $('#no-selected-job-category').hide();
        getCategorySpecifics();
    });

    if (category) {
        $('#job_category_id').trigger('change');
    } else {
        $('#no-selected-job-category').show();
    }

	function moveToStep(step) {
		$('#'+step).trigger('click');
	}

    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

	function getCategorySpecifics()
	{
		NProgress.start();
		$.ajax( {
			type: "GET",
			url: '/dashboard/job-post-template/'+ $('#job_category_id').val(),
			success: function( response ) {
				var toStep4 = "event.preventDefault(); moveToStep('step-4-section');";
				var toStep5 = "event.preventDefault(); moveToStep('step-5-section');";

				if(response.images_option) {
					$('li.images_option').show();
					$('#step-3 .action-buttons button{{ (request()->vendor_id) ? "#submit-quote-request" : "#submit-job-post"}}').hide();
					$('#step-3 .action-buttons a').attr('onClick', toStep4).show();
					$('#step-5-section').text('Step 5')
					$('#step-6-section').text('Step 6')
				} else {
					$('li.images_option').hide();
					$('#step-3 .action-buttons button{{ (request()->vendor_id) ? "#submit-quote-request" : "#submit-job-post"}}').show();
					$('#step-3 .action-buttons a').attr('onclick', toStep5){{ (!request()->vendor_id) ? ".hide()" : ""}};
					$('#step-5-section').text('Step 4')
					$('#step-6-section').text('Step 5')
				}

				if(response.fields) {
					var fields = JSON.parse(response.fields), template = $('#template'), counter = 1, req = '';
					if(response.approxDisplay) {
						if(response.approximate) {
							$('#approximate').attr('placeholder', 'Approx number of guests *')
						}else {
							$('#approximate').attr('placeholder', 'Approx number of guests')
						}
					}else {
						$('.approx').addClass('hide')
					}
					$.each(fields, function(field){
						var html = '', required = '';
						if(this.type == 'address') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
								<textarea name="required_address" placeholder="`+htmlEntities(this.text)+req+`" class="form-control"></textarea>
							</div><br>`
						}else if(this.type == 'time') {
							required = (this.req) ? 'disabled selected' : '';
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										<select name="job_time_requirement_id" class="form-control">
											<option value="" class="grey-input" `+required+`>`+this.text+req+`</option>
											@foreach($jobTimeRequirements as $time)
											<option value="{{ $time->id }}">
												{{ $time->name }}
											</option>
											@endforeach
										</select>
									</div><br>`
						}else if(this.type == 'date') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
										<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
										<div data-provide="datepicker"
											data-date-format="dd/mm/yyyy"
											data-date-start-date="+1d"
											class="wb-form-group input-group date bootstrap-timepicker"
											style="margin-bottom: 0;">
											<div class="input-group">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input
													id="f`+counter+`"
													type="text"
													onkeydown="return false"
													name="fields[`+counter+`][val]"
													class="form-control"
													placeholder="`+htmlEntities(this.text)+req+`">
												<div class="input-group-addon" onclick="$('#f`+counter+`').val('')">
													<span class="fa fa-times text-danger"></span>
												</div>
											</div>
										</div>
									</div><br>`
							counter++;
						}else if(this.type == 'time2') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										<div class="bootstrap-timepicker">
											<div class="input-group">
												<div class="input-group-addon">
													<span class="fa fa-clock-o"></span>
												</div>
												<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
												<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
												<input id="t`+counter+`" type="text" name="fields[`+counter+`][val]" class="form-control timepicker" placeholder="`+htmlEntities(this.text)+req+`">
												<div class="input-group-addon" onclick="$('#t`+counter+`').val('')">
													<span class="fa fa-times text-danger"></span>
												</div>
											</div>
										</div>
									</div><br>`
							counter++;
						}else if(this.type == 'text') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										${ this.icon ? `<div class="input-group">` : ``} 
											${ this.icon ? `<span class="input-group-addon" id="basic-addon1"> <i class="${this.icon}"></i> </span>` : ``} 
											
											<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
											<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
											<input type="text" name="fields[`+counter+`][val]" placeholder="`+htmlEntities(this.text)+req+`" class="form-control">
										${ this.icon ? `</div>` : ``} 
										
									</div><br>`
							counter++;
						}if(this.type == 'ltext') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
								<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
								<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
								<textarea name="fields[`+counter+`][val]" placeholder="`+htmlEntities(this.text)+req+`" class="form-control"></textarea>
							</div><br>`;
							counter++;
						}else if(this.type == 'numeric') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										${ this.icon ? `<div class="input-group">` : ``} 
											${ this.icon ? `<span class="input-group-addon" id="basic-addon1"> <i class="${this.icon}"></i> </span>` : ``} 
											<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
											<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
											<input type="number" name="fields[`+counter+`][val]" placeholder="`+htmlEntities(this.text)+req+`" class="form-control">
										${ this.icon ? `</div>` : ``} 
									</div><br>`
							counter++;
						}else if(this.type == 'currency') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
										<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1"> <i class="fa fa-dollar"></i> </span>
											<input type="number" name="fields[`+counter+`][val]" placeholder="`+htmlEntities(this.text)+req+`" class="form-control">
										</div>
									</div><br>`
							counter++;
						}else if(this.type == 'custom') {
							var option = '', options = this.opts.split(",");
							required = (this.req) ? 'disabled selected' : '';
							req = (this.req) ? ' *' : '';
							for(var i = 0; i < options.length; i++) {
								option += '<option value="'+options[i]+'">'+options[i]+'</option>';
							}
							html = `<div class="wb-form-group">
										<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
										<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
										<select name="fields[`+counter+`][val]" class="form-control">
											<option value="" class="grey-input" `+required+`>`+this.text+req+`</option>`+option+`
										</select>
									</div><br>`
							counter++;
						}else if(this.type == 'custom_multi') {
							var multi_options = '';

							this.opts.split(',').map((opt, i) => {
								multi_options += `<li>
									<input id="multi-${i}" type="checkbox"
									name="fields[${counter}][val][]"
									value="${opt}" />
									<label for="multi-${i}" style="text-transform: capitalize; margin: 0;">${opt}</label>
								</li>`
							})
											
							req = (this.req) ? ' *' : '';
							
							html = `<div class="wb-form-group">
										<input type="hidden" name="fields[`+counter+`][title]" value="`+htmlEntities(this.jtext)+`">
										<input type="hidden" name="fields[`+counter+`][type]" value="`+this.type+`">
										<dl class="selectdropdown jobstep" style="width: 100%;">
											<dt>
												<a class="dropdown" style="background: url('/assets/images/angle-down-16.png') #e9e5e4 no-repeat calc(100% - 10px);">
													<p class="multiSel">
														<span title="wedBooker">`+this.text+req+`</span>
													</p>
												</a>
											</dt>
											<dd>
												<div class="mutliSelect">
													<ul style="height: auto; max-height: 200px;">
														${multi_options}
													</ul>
												</div>
											</dd>
										</dl>
									</div><br>`
							counter++;
						}else if(this.type == 'property') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										<dl class="selectdropdown jobstep" style="width: 100%;">
											<dt>
												<a class="dropdown" style="background: url('/assets/images/angle-down-16.png') #e9e5e4 no-repeat calc(100% - 10px);">
													<p class="multiSel" id="property-types">
														<span title="wedBooker">`+this.text+req+`</span>
													</p>
												</a>
											</dt>
											<dd>
												<div class="mutliSelect">
													<ul>
														@php
														if(isset($jobPost)) {
															$currentPropertyTypeIds = $jobPost->propertyTypes->pluck('id')->toArray();
														}
														@endphp
														@foreach($propertyTypes as $prop)
														<li>
															<input id="prop-{{ $prop->id }}" type="checkbox"
															name="property_types[]"
															value="{{ $prop->name}}" />
															<label for="prop-{{ $prop->id }}" style="text-transform: capitalize; margin: 0;">{{ $prop->name }}</label>
														</li>
														@endforeach
													</ul>
												</div>
											</dd>
										</dl>
									</div><br>`
						}else if(this.type == 'other') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										<dl class="selectdropdown jobstep" style="width: 100%;">
											<dt>
												<a class="dropdown" style="background: url('/assets/images/angle-down-16.png') #e9e5e4 no-repeat calc(100% - 10px);">
													<p class="multiSel" id="other-requirements">
														<span title="wedBooker">`+this.text+req+`</span>
													</p>
												</a>
											</dt>
											<dd>
												<div class="mutliSelect">
													<ul>
														@php
														if(isset($jobPost)) {
															$currentJobRequirementsIds = $jobPost->propertyFeatures->pluck('id')->toArray();
														}
														@endphp
														@foreach($propertyFeatures as $feature)
														<li>
															<input id="feature-{{ $feature->id }}" type="checkbox"
															name="property_features[]"
															value="{{ $feature->name}}" />
															<label for="feature-{{ $feature->id }}" style="text-transform: capitalize; margin: 0;">{{ $feature->name }}</label>
														</li>
														@endforeach
													</ul>
												</div>
											</dd>
										</dl>
									</div><br>`
						}else if(this.type == 'website') {
							req = (this.req) ? ' *' : '';
							html = `<div class="wb-form-group">
										<dl class="selectdropdown jobstep" style="width: 100%;">
											<dt>
												<a class="dropdown" style="background: url('/assets/images/angle-down-16.png') #e9e5e4 no-repeat calc(100% - 10px);">
													<p class="multiSel" id="website-requirements">
														<span title="wedBooker">`+this.text+req+`</span>
													</p>
												</a>
											</dt>
											<dd>
												<div class="mutliSelect">
													<ul>
														@php
														if(isset($jobPost)) {
															$currentWebsiteRequirementIds = $jobPost->websiteRequirements->pluck('id')->toArray();
														}
														@endphp
														@foreach($websiteRequirements as $req)
														<li>
															<input id="req-{{ $req->id }}" type="checkbox"
															name="website_requirements[]"
															value="{{ $req->name}}" />
															<label for="req-{{ $req->id }}" style="text-transform: capitalize; margin: 0;">{{ $req->name }}</label>
														</li>
														@endforeach
													</ul>
												</div>
											</dd>
										</dl>
									</div><br>`
						}
						template.append(html);
						$('.timepicker').timepicker({
							showInputs: false
						})
					})
				}

				$('#additional-options').val((response.body) ? response.body : '');
				NProgress.done();
                $('#custom-text').text(response.custom_text ? response.custom_text : '')
				
				@if(isset($jobPost) || session('_old_input'))
					insertOldValues($('#job_category_id').val());
				@endif
			}
		});
	}

	// $('{{ (request()->vendor_id) ? "#submit-quote-request" : "#submit-job-post"}}').on('click', function(){
	// 	$('#job-specifics').val($('#job-specifics-html').html());
	// })

	var imagesPreview = function(input, placeToInsertImagePreview) {
        var previewWrapper = $(placeToInsertImagePreview);
        previewWrapper.html('');
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
				var file = input.files[i];

				reader.onload = (function(f, i) { 
					return function(event) {
						previewWrapper.append(
							'<div class="item jobImg"><div class="delImg" data-file="'+i+'"><i class="fa fa-close fa-2x" style="color: #ff0000;"></i></div>' +
							'<img src="'+event.target.result+'" class="img-responsive" width="143" />' +
							'</div>'
						);
					};
				})(file, i);

                reader.readAsDataURL(input.files[i]);
            }
        }
    };

	function validateFileSize(input) {
		var max = 10000000;
		var valid = true;
		var filesAmount = input.files.length;

		for (i = 0; i < filesAmount; i++) {
			if (input.files[i].size > max) {
				valid = false;
				break;
			}
		}

		return valid;
	}

	function validateFileType(input) {
		var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
		var valid = true;
		var filesAmount = input.files.length;

		for (i = 0; i < filesAmount; i++) {
			if (!validTypes.includes(input.files[i].type)) {
				valid = false;
				break;
			}
		}

		return valid;
	}

	$('#add-photos').on('change', function() {
		if (! validateFileType(this)) {
			alert('The Image must be a file of type: jpeg, png.');
			$(this).val('');
			return false;
		}

		if (! validateFileSize(this)) {
			alert('Image size may not be greater than 10MB.');
			$(this).val('');
			return false;
		}

		imagesPreview(this, 'div.gallery:not(.updateJob)');
	});
	
	$('body').on('click', '.jobImg', function() {		
        let photoId = $(this).find('.delImg').attr('data-file');

		if($(this).hasClass('updateJob')) {
			NProgress.start();

			axios.post('/media/'+ photoId, {
				_method: 'DELETE'
			}).then(() => {
				$(this).remove();
				NProgress.done();
			});
		}else {
			$(this).remove();
		}
	})
	
	@if(isset($jobPost) || session('_old_input'))
	function insertOldValues(category) {
		var category_old = {{ isset($jobPost->category_id) ? $jobPost->category_id : 0 }},
			required_address = '{{ isset($jobPost->required_address) ? $jobPost->required_address : null }}',
			specifics = '{{ isset($jobPost->specifics) ? $jobPost->specifics : null }}',
			job_time_requirement_id = {{ isset($jobPost->job_time_requirement_id) ? $jobPost->job_time_requirement_id : 'null' }},
			property_types = {!! count($jobPost->propertyTypes) ? json_encode($jobPost->propertyTypes->pluck('name')) : 'null' !!},
			property_features = {!! count($jobPost->propertyFeatures) ? json_encode($jobPost->propertyFeatures->pluck('name')) : 'null' !!},
			website_requirements = {!! count($jobPost->websiteRequirements) ? json_encode($jobPost->websiteRequirements->pluck('name')) : 'null' !!},
			oldFields = {!! isset($jobPost->fields) ? $jobPost->fields : 'null' !!};

		if(category == category_old) {
			if(required_address != '' || required_address != null) {
				$('textarea[name="required_address"]').val(required_address)
			}
			if(specifics != '' || specifics != null) {
				$('#additional-options').val(specifics)
			}
			if(job_time_requirement_id != '' || job_time_requirement_id != null) {
				$('select[name="job_time_requirement_id"]').val(job_time_requirement_id)
			}
			if(property_features != null) {
				$.each(property_features, function(i, v) {
					$('input[name="property_features[]"][value="' + v + '"]').trigger('click')
				})
			}
			if(property_types != null) {
				$.each(property_types, function(i, v) {
					$('input[name="property_types[]"][value="' + v + '"]').trigger('click')
				})
			}
			if(website_requirements != null) {
				$.each(website_requirements, function(i, v) {
					$('input[name="website_requirements[]"][value="' + v + '"]').trigger('click')
				})
			}

			$.each(oldFields, function(i) {
				if(oldFields[i].type == 'custom') {
					$('select[name="fields[' + i + '][val]"]').val(oldFields[i].val)
				}else if(oldFields[i].type == 'custom_multi') {
					$.each(oldFields[i].val, function(j, v) {
						$('input[name="fields[' + i + '][val][]"][value="' + v + '"]').trigger('click')
					})
				}else if(oldFields[i].type == 'ltext') {
					$('textarea[name="fields[' + i + '][val]"]').val(oldFields[i].val)
				}else {
					$('input[name="fields[' + i + '][val]"]').val(oldFields[i].val)
				}
			})
		}
	}
	@endif
	</script>
@endpush

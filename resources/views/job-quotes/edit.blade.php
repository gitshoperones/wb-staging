@extends('layouts.dashboard')

@section('content')
    @if(session()->has('modal_message'))
        @include('modals.success-modal', [
            'header' => 'JOB QUOTE',
            'message' => session('modal_message'),
        ])
    @endif
    @include('modals.errors-modal', [
        'header' => 'Oops',
        'message' => 'You still need to complete some fields in order to submit your quote',
    ])
    <div class="wb-bg-grey wb-cc-quotation content" id="wb-cc-quotation">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <form action="{{ url(sprintf('/dashboard/job-quotes/%s', $jobQuote->id)) }}"
                        method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="wb-box wb-tab-send-quote" style="margin-top: 43px; padding: 35px;">
                            @include('partials.alert-messages')
                            <div class="alert alert-danger wd-alert-danger" style="display: none;">
                                <span id="errors"></span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_step_1" onClick="resetStepTo(1)" id="cc-quote-tab-1" data-toggle="tab">Step 1</a>
                                </li>
                                <li>
                                    <a href="#tab_step_2" onClick="resetStepTo(2)" id="cc-quote-tab-2" data-toggle="tab">Step 2</a>
                                </li>
                                <li>
                                    <a href="#tab_step_3" onClick="resetStepTo(3)" id="cc-quote-tab-3" data-toggle="tab">Step 3</a>
                                </li>
                                <li>
                                    <a href="#tab_step_4" onClick="resetStepTo(3)" id="cc-quote-tab-4" data-toggle="tab">Step 4</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                @include('partials.job-quotes.step-1')
                                @include('partials.job-quotes.step-2')
                                @include('partials.job-quotes.step-3')
                                @include('partials.job-quotes.step-4')
                            </div>
                            <div class="wb-send-quote" style="text-align: right;">
                                <div>
                                    <div class="action-buttons" style="inline">
                                        <button id="draft-quote"
                                            type="submit"
                                            name="status"
                                            value="0"
                                            style="font-weight: 300;"
                                            class="btn wb-btn-outline-default">
                                            SAVE AS DRAFT
                                        </button>
                                        <button id="submit-quote"
                                            type="submit"
                                            name="status"
                                            value="1"
                                            style="font-weight: 300;"
                                            class="hidden btn wb-btn-orange submit-quote">
                                            SUBMIT QUOTE
                                        </button>
                                        <button id="next-step"
                                            value="1"
                                            style="font-weight: 300;"
                                            class=" btn wb-btn-orange">
                                            NEXT STEP
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @include('partials.job-quotes.job-details')
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    var step = 1;

    $('#next-step').on('click', function(e){
        e.preventDefault();
        step = parseInt($(this).val());
        step += 1;

        if (step > 4) {
            step = 4;
        }

        $(this).val(step);
        $('#cc-quote-tab-'+step).trigger('click');
        toggleBtn(step);
    });

    $('html').on('keypress', function(e) {
        if (e.keyCode == 13 && e.target.id != 'message-editor') {
            $('#next-step').trigger('click');
            return false;
        }
    });

    function resetStepTo(step) {
        $('#next-step').val(step);
        toggleBtn(step);
    }

    function toggleBtn(step) {
        $('#next-step').val(step);
        if (step >= 4) {
            $('#next-step').hide();
            $('#submit-quote').removeClass('hidden');
        } else {
            $('#next-step').show();
            $('#submit-quote').addClass('hidden');
        }
    }
    $('#submit-quote').on('click', function(e) {
        var errors = '';
        if(window._wbQuote_.totalPayable <= 0) {
            e.preventDefault();
            errors += '<p>- Please add description and amount to your quote in step 1.</p>';
        }

        var totalQuote = 0;

        $('.percent-due').each(function(){
            totalQuote += parseFloat($(this).val());
        });

        if(totalQuote !== 100) {
            e.preventDefault();
            errors += '<p>- Your deposit and balance must add up to $' + window._wbQuote_.totalPayable + ' in step 2.</p>';
        }

        if($('#message').val() == '') {
            e.preventDefault();
            errors += '<p>- Please add personalize message.</p>';
        }

        if(!$('#confirm-availability').is(':checked')) {
            e.preventDefault();
            errors += '<p>- Confirming your business availability by checking the box.</p>';
        }

		if(errors != '') {
			$('#errors').parent().show();
			$('#errors').html(errors);
			$('#error-fields').modal('show');
		}
    });

	$('body').on('click', '.jobImg', function() {		
		let photoId = $(this).find('.delImg').attr('data-file'),
			galId = $(this).attr('data-galId');

		if($(this).hasClass('updateQuote')) {
			NProgress.start();

			axios.post('/media/'+ photoId, {
				_method: 'DELETE'
			}).then(() => {
				$(this).remove();
				NProgress.done();
			});
		}else if($(this).hasClass('img-profile-gallery')) {
			$(this).remove();
			$(`#${galId}`).trigger('click');
		}else {
			$(this).remove();
		}
	})

    $('body').on('click', '.quoteFile', function() {		
        let fileId = $(this).find('.delFile').attr('data-file');

        if($(this).hasClass('updateQuote')) {
            NProgress.start();

            axios.post('/file/'+ fileId, {
                _method: 'DELETE'
            }).then(() => {
                $(this).remove();
                NProgress.done();
            });
        }else {
            $(this).remove();
        }
    })

    @if (request('extend') === 'true')
        $('#cc-quote-tab-2').trigger('click');
    @endif
</script>
@endpush


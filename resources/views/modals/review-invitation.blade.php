<!-- Onboarding Modal -->
<div class="modal fade" id="setup-vendor-review" role="dialog">
    <div id="wb-modal-vendor4b" class="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="row mt20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <br />
                                <h2 class="title wide medium" style="margin: 10px 0;">Build Your Star Rating</h2>
                                <br />
                                <label class="form-control">
                                    Make sure you have a star rating to ensure you win more work. Provide the details of two past couples that you have provided services for at their wedding, so that we can ask them to review your business!
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt20">
                        <br/>
                        <p class="text-primary">Couple 1</p>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="couple1-name" type="text" name="couple1_name" class="form-control" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="couple1-email" type="text" name="couple1_email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="row mt20">
                        <br/>
                        <p class="text-primary">Couple 2</p>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="couple2-name" type="text" name="couple2_name" class="form-control" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="couple2-email" type="text" name="couple2_email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <br/>
                                <input id="agree" type="checkbox" name="agree" class="form-control">
                                <label for="agree" class="form-control">
                                    I agree and confirm that these are true Couples who have utilised my wedding services and agree to wedBooker sending an email to these Couples to seek a Review of your wedding services for inclusion in your wedBooker profile.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <br/><br/>
                        <a href="#" data-dismiss="modal"
                            class="btn-fixed-1-2 step2 wb-btn wb-btn-lg wb-btn-gray back">
                            Close
                        </a>
                        <a id="submit-review-request" href="#"
                            class="btn-fixed-2-1 step2 wb-btn wb-btn-lg wb-btn-orange">
                            Submit
                        </a><br/><br/><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade onboarding-wrapper vendor" id="review-invitation-error" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
    <div id="wb-modal-vendor5" class="modal-dialog">
        <div class="modal-dialog">
            <div class="icon-wrappers onboarding couple">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="modal-content text-center">
                <div class="modal-body">
                    <h2 class="title">Form Error</h2>
                    <div class="desc wide" id="review-invitation-error-message"></div>
                    <br /><br />
                    <button type="button" class="step2 wb-btn wb-btn-lg wb-btn-orange" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    var msg = '';

    $('#submit-review-request').on('click', function(e) {
        e.preventDefault();

        var couple1Email = $('#couple1-email').val();
        $('#c1email').val(couple1Email);
        var couple1Name = $('#couple1-name').val();
        $('#c1name').val(couple1Name);
        var couple2Email = $('#couple2-email').val();
        $('#c2email').val(couple2Email);
        var couple2Name = $('#couple2-name').val();
        $('#c2name').val(couple2Name);

        if (!couple1Email && !couple2Email) {
            msg = 'Please enter atleast 1 couple email and full name.';
            showErrorModal();
            return false;
        }

        if (couple1Email && !validateEmail(couple1Email)) {
            msg = 'Please enter valid couple 1 email.';
            showErrorModal();
            return false;
        }

        if (couple1Email && !couple1Name) {
            msg = 'Please enter couple 1 full name.';
            showErrorModal();
            return false;
        }

        if (couple2Email && !validateEmail(couple2Email)) {
            msg = 'Please enter valid couple 2 email.';
            showErrorModal();
            return false;
        }

        if (couple2Email && !couple2Name) {
            msg = 'Please enter couple 2 full name.';
            showErrorModal();
            return false;
        }

        if ((couple2Email || couple1Email) && couple2Email === couple1Email) {
            msg = 'Please enter unique couple 2 email.';
            showErrorModal();
            return false;
        }

        if ((couple1Email || couple2Email) && !$('#agree').prop('checked')) {
            msg = 'Please accept the agreement.';
            showErrorModal();
            return false;
        }

        $('#request-review-form').submit();
    });

    function showErrorModal() {
        $('#review-invitation-error').modal('show');
        $('#review-invitation-error-message').text(msg);
    }

    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
</script>
@endpush
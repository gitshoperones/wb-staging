<form class="form-horizontal text-primary" id="wedbooker-credit-card-payment-form">
    <div class="modal fade" id="credit-card-payment-errors-modal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div id="wb-modal-success" class="modal-dialog">
            <div class="modal-dialog">
                <div class="modal-content text-center">
                    <div class="modal-header">Transaction Error</div>
                    <div class="modal-body">
                        <div v-for="(error, key) in errors" class="alert wd-alert-danger fade in">
                            <p v-for="msg in error">
                                @{{ msg }}
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (count($creditCards) > 0)
    <div class="form-group">
        <label class="col-sm-5 control-label">Use Saved Credit Card</label>
        <div class="col-sm-7">
            <select id="credit-card-" class="form-control" v-model="cardAccountId" @change="savedCardSelected">
                <option value="">Select</option>
                @foreach($creditCards as $card)
                    <option value="{{ $card->card_account_id }}">
                        {{ ucwords($card->card['type']) }}
                        {{ $card->card['number'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
    <div class="form-group form-check-inline">
        <label class="col-sm-5 control-label">Card Type<span class="required">*</span></label>
        <div class="col-sm-7">
            <div class="cc-selector">
                <input id="visa-type" type="radio" name="card_type" value="visa" :disabled="disableCreditCardInput"/>
                <label class="drinkcard-cc visa" for="visa-type"></label>
                <input id="mastercard-type" type="radio" name="card_type" value="mastercard" :disabled="disableCreditCardInput"/>
                <label class="drinkcard-cc mastercard"for="mastercard-type"></label>
            </div>
            {{-- <input type="radio" id="visa-type" name="card_type" class="form-check-input" :disabled="disableCreditCardInput">
            <label for="visa-type" class="form-check-label">
                Visa 
            </label>
            <input type="radio" id="mastercard-type" name="card_type" class="form-check-input" :disabled="disableCreditCardInput">
            <label for="mastercard-type" class="form-check-label">
                Mastercard
            </label> --}}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Card Name <span class="required">*</span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" v-model="fullName" :disabled="disableCreditCardInput">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Card Number <span class="required">*</span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" v-model="ccNumber" :disabled="disableCreditCardInput">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Expiry <span class="required">*</span></label>
        <div class="col-sm-3">
            <input type="text" placeholder="MM" class="form-control" v-model="expMonth" maxlength="2">
        </div>
        <div class="col-sm-3">
            <input type="text" placeholder="YY" class="form-control" v-model="expYear" maxlength="2">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">CVV <span class="required">*</span></label>
        <div class="col-sm-3">
            <input type="text" class="form-control" v-model="cvv" :disabled="disableCreditCardInput">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Postcode <span class="required">*</span></label>
        <div class="col-sm-3">
            <input type="text" class="form-control" v-model="zip">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5"></label>
        <div class="col-sm-7">
            <div class="form-check" v-show="!disableCreditCardInput">
                <input type="checkbox" value="yes" class="form-check-input" id="save-cc" v-model="saveCC">
                <label class="form-check-label" for="save-cc">Save Credit Card</label>
              </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-10">
            <button type="submit" :disabled="processing" @click.prevent="pay" class="btn wb-btn-orange">@{{ payButtonLabel }}</button>
        </div>
        <br/>
        <br/>
        <br/>
        <p class="text-center" v-if="processing"><strong>Please don't refresh your browser until payment is processed.</strong></p>
    </div>
    <input type="hidden" id="cInvoiceId" value="{{ $invoice->id }}">
    <input type="hidden" id="errorMessages" value="{{ json_encode($errorMessages) }}">
</form>

@push('styles')
    <style>
        .swal-title {
            font-family: 'Josefin Slab';
            text-transform: uppercase;
            color: #353554;
        }

        .swal-text,
        .swal-footer {
            font-family: 'Ubuntu';
            font-weight: 200;
            text-align: center;
            color:#353554;
        }

        .swal-button {
            border-radius: 0;
            background-color: #FE5945;
            text-transform: uppercase;
        }
        .swal-button--cancel {
            background-color: #f4e9e4;
        }
        .swal-button.swal-button--confirm:hover {
            background-color: #E65749 !important;
        }
        .swal-button--cancel:hover {
            background-color: #ECE4E1 !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        let cToken = document.querySelector('meta[name="csrf-token"]');
        let userInvoiceId = $('#cInvoiceId').val();
        let wbErrorMessages = $('#errorMessages').val();

        if (cToken) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = cToken.content;
        } else {
            console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }

        var wedbookerPayment = new Vue({
            el: '#wedbooker-credit-card-payment-form',
            computed: {
                payButtonLabel() {
                    return this.btnLabel;
                },
                disableCreditCardInput() {
                    return this.cardAccountId !== '';
                }
            },
            mounted() {
                $('#wb-single-quote').removeClass('primary-assets-not-loaded');
                $('#loading-assets-notification').hide();
                $('.invoice-payable:first').prop('checked', true);
            },
            data: {
                errorMessages: JSON.parse(wbErrorMessages),
                useSavedCard: false,
                deviceId: '',
                ipAddress: '',
                saveCC: false,
                cardAccountId: '',
                cInvoiceId: userInvoiceId,
                authToken: '',
                fullName: '',
                ccNumber: '',
                expMonth: '',
                expYear: '',
                cvv: '',
                zip: '',
                milestoneIds: [],
                errors: null,
                processing: false,
                btnLabel: 'PAY NOW',
            },
            methods: {
                savedCardSelected() {
                    if(this.cardAccountId) {
                        this.useSavedCard = true;
                    } else {
                        this.useSavedCard = false;
                    }
                },
                pay() {
                    var self = this;

                    self.setClosePrompt();

                    if (self.processing) {
                        return false;
                    }

                    self.milestoneIds = [];

                    $('.invoice-payable:checked').each(function(){
                        self.milestoneIds.push($(this).val());
                    });

                    if (!self.milestoneIds.length) {
                        alert('Please select payable amount.');
                        return false;
                    }

                    self.fullName = self.fullName.trim();
                    self.ccNumber = self.ccNumber.trim();

                    if (!self.useSavedCard) {
                        if (!self.fullName) {
                            alert('Card Name is required.');
                            return false;
                        }

                        if (!self.ccNumber) {
                            alert('Card Number is required.');
                            return false;
                        }

                        if (!self.expMonth) {
                            alert('Expiration Month is required.');
                            return false;
                        }

                        if (!self.expYear) {
                            alert('Expiration Year is required.');
                            return false;
                        }

                        if (!self.cvv) {
                            alert('Card CVV is required.');
                            return false;
                        }

                        if (!self.zip) {
                            alert('Zip code is required.');
                            return false;
                        }
                    } else {
                        if (!self.expMonth) {
                            alert('Expiration Month is required.');
                            return false;
                        }

                        if (!self.expYear) {
                            alert('Expiration Year is required.');
                            return false;
                        }
                        if (!self.zip) {
                            alert('Zip code is required.');
                            return false;
                        }
                    }

                    swal({
                        title: 'Ready to confirm booking?',
                        text: "Are you ready to pay the {{ ($invoice->balance == $invoice->total) ? 'deposit' : 'balance' }} & confirm this booking?",
                        type: 'warning',
                        width: 600,
                        padding: '3em',
                        buttons: ['Cancel', 'Yes'],
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#FE5945',
                        cancelButtonColor: '#f4e9e4',
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        if (result) {
                            self.startLoader();
                            self.captureDeviceId();
                        }
                    });
                },
                captureDeviceId() {
                    var self = this;
                    promisepay.captureDeviceId(function(data){
                        if (!data) {
                            self.logError(error);
                            return self.stopLoader();
                        }

                        self.deviceId = data;
                        self.getIPAddress();
                    });
                },
                getIPAddress() {
                    var self = this;
                    promisepay.getIPAddress(function(data){
                        if (!data) {
                            self.logError(error);
                            return self.stopLoader();
                        }

                        self.ipAddress = data;

                        if (self.cardAccountId) {
                            return self.payUsingExitingCreditCard();
                        }

                        return self.payUsingNewCreditCard();
                    });
                },
                payUsingExitingCreditCard() {
                    this.makePayment(this.cardAccountId);
                },
                payUsingNewCreditCard() {
                    var self = this;

                    self.errors = null;

                    axios.post('/payment-gateway-auth-token',{
                        zip: self.zip
                    }).then(function(res){
                        self.authToken = res.data.token;
                        self.captureCreditCard();
                    }).catch(function(error) {
                        self.logError(error);
                        self.stopLoader();
                    });
                },
                captureCreditCard() {
                    var self = this;

                    promisepay.createCardAccount(self.authToken,
                        {
                            full_name: self.fullName,
                            number: self.ccNumber,
                            expiry_month: parseInt(self.expMonth),
                            expiry_year: parseInt('20' + self.expYear),
                            cvv: self.cvv
                        },
                        function(data){
                            self.makePayment(data.id);
                        },
                        function(data){
                            self.logError(data.responseJSON.errors);
                            self.stopLoader();
                        },
                    );
                },
                makePayment(cardAccountId) {
                    var self = this;

                    axios.post('/payments', {
                        useSavedCard: self.useSavedCard,
                        cardAccountId: cardAccountId,
                        deviceId: self.deviceId,
                        ipAddress: self.ipAddress,
                        saveCC: self.saveCC,
                        invoiceId: self.cInvoiceId,
                        milestoneIds: self.milestoneIds,
                        zip: self.zip,
                        expYear: self.expYear,
                        expMonth: self.expMonth,
                    }).then(function(res){
                        self.addToGoogleRevenueTracking(res.data);
                        // $('#success-confirmation').modal('show');
                        self.resetForm();
                        window.location.href = "{{ url('/payments/thanks?v='.$invoice->vendor->id) }}";
                    }).catch(function(error){
                        self.logError(error);
                        self.stopLoader();
                    });
                },
                startLoader() {
                    let self = this;
                    let counter = 1;
                    self.btnLabel = 'Processing';
                    self.processing = true;
                    self.errors = null;

                    window.wbLoader = setInterval(function() {
                        if (counter <= 3) {
                            self.btnLabel += ' . ';
                            counter++;
                        } else {
                            counter = 1;
                            self.btnLabel = 'Processing';
                        }
                    }, 1000);
                },
                stopLoader() {
                    this.processing = false;
                    this.btnLabel = 'PAY NOW';
                    clearInterval(window.wbLoader);
                    this.unSetClosePrompt();
                },
                logError(error) {
                    let msg = '';

                    if (error.response && error.response.data.message) {
                        for(var i in this.errorMessages) {
                            let customMsg = this.errorMessages[i].original_message ? this.errorMessages[i].original_message.toLowerCase() : '';
                            let apiMsg = error.response.data.message.toLowerCase();

                            if (customMsg === apiMsg) {
                                msg = this.errorMessages[i].custom_message;
                                break;
                            }
                        }
                    }

                    if (!msg || msg == '') {
                        msg = 'Your payment has been declined. Error code 630';
                    }

                    this.errors = {Transaction: [msg]};
                    this.showErrorModal();
                },
                addToGoogleRevenueTracking(data) {
                    var transaction = {
                        'id': data.id,
                        'affiliation': 'WedBooker',
                        'revenue': data.amount,
                        'shipping': 0,
                        'tax': data.tax
                    };

                    ga('ecommerce:addTransaction', transaction);
                    ga('ecommerce:send');
                    ga('ecommerce:clear');
                },
                setClosePrompt() {
                    window.onbeforeunload = function(e) {
                        var dialogText = 'Your Payment is still processing. Are you sure you want to leave this page?';
                        e.returnValue = dialogText;
                        return dialogText;
                    };
                },
                unSetClosePrompt() {
                    window.onbeforeunload = null;
                },
                showErrorModal() {
                    $('#credit-card-payment-errors-modal').modal('show');
                },
                resetForm() {
                    this.useSavedCard = false;
                    this.deviceId = '';
                    this.ipAddress = '';
                    this.cInvoiceId = userInvoiceId;
                    this.authToken = '';
                    this.fullName = '';
                    this.ccNumber = '';
                    this.expMonth = '';
                    this.expYear = '';
                    this.cvv = '';
                    this.zip = '';
                    this.milestoneIds = [];
                    this.errors = null;
                    this.stopLoader();
                },
            }
        });
    </script>
@endpush
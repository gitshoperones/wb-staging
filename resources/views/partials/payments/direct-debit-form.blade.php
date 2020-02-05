<form class="form-horizontal" id="wedbooker-direct-debit-payment-form">
    <div class="modal fade" id="debit-payment-errors-modal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
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
    <div class="form-group">
        <label class="col-sm-5 control-label">Bank Name <span class="required">*</span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" v-model="bankName">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Account Holder Name <span class="required">*</span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" v-model="accountName">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">BSB <span class="required">*</span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" v-model="routingNumber">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Account Number <span class="required">*</span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" v-model="accountNumber">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Account Type <span class="required">*</span></label>
        <div class="col-sm-7">
            <select id="credit-card-" class="form-control" v-model="accountType">
                <option value="savings">Savings</option>
                <option value="checking">Checking</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">Holder Type <span class="required">*</span></label>
        <div class="col-sm-7">
            <select id="credit-card-" class="form-control" v-model="holderType">
                <option value="personal">Personal</option>
                <option value="business">Business</option>
            </select>
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
<script type="text/javascript">
    let dToken = document.querySelector('meta[name="csrf-token"]');
    let dUserInvoiceId = $('#cInvoiceId').val();
    let dErrorMessages = $('#errorMessages').val();

    if (dToken) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = dToken.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    var wedbookerPayment = new Vue({
        el: '#wedbooker-direct-debit-payment-form',
        computed: {
            payButtonLabel() {
                return this.btnLabel;
            },
        },
        mounted() {
            $('.invoice-payable:first').prop('checked', true);
        },
        data: {
            errorMessages: JSON.parse(dErrorMessages),
            deviceId: '',
            ipAddress: '',
            cardAccountId: '',
            dInvoiceId: dUserInvoiceId,
            authToken: '',
            bankName: '',
            accountName: '',
            routingNumber: '',
            accountNumber: '',
            accountType: 'savings',
            holderType: 'personal',
            milestoneIds: [],
            errors: null,
            processing: false,
            btnLabel: 'PAY NOW',
        },
        methods: {
            pay() {
                var self = this;
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

                if (!self.bankName) {
                    alert('Bank Name is required.');
                    return false;
                }

                if (!self.accountName) {
                    alert('Account Name is required.');
                    return false;
                }

                if (!self.routingNumber) {
                    alert('BSB is required.');
                    return false;
                }

                if (!self.accountNumber) {
                    alert('Account Number is required.');
                    return false;
                }

                if (!self.accountType) {
                    alert('Account Type is required.');
                    return false;
                }

                if (!self.holderType) {
                    alert('Holder Type is required.');
                    return false;
                }

                self.startLoader();
                self.captureDeviceId();
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

                    return self.payUsingDirectDebit();
                });
            },
            payUsingDirectDebit() {
                var self = this;
                self.errors = null;

                axios.post('/payment-gateway-auth-token',{
                    type: 'bank',
                    zip: self.zip
                }).then(function(res){
                    self.authToken = res.data.token;
                    self.captureBankAccount();
                }).catch(function(error) {
                    self.logError(error);
                    self.stopLoader();
                });
            },
            captureBankAccount() {
                var self = this;

                promisepay.createBankAccount(self.authToken,
                    {
                        bank_name: self.bankName,
                        account_name: self.accountName,
                        routing_number: self.routingNumber,
                        account_number: self.accountNumber,
                        account_type: self.accountType,
                        holder_type: self.holderType,
                        country: 'AUS',
                        payout_currency: 'AUD'
                    },
                    function(data){
                        self.makePayment(data.id);
                    }
                )
            },
            makePayment(bankAccountId) {
                var self = this;

                axios.post('/payments', {
                    modeOfPayment: 'directDebit',
                    cardAccountId: bankAccountId,
                    deviceId: self.deviceId,
                    ipAddress: self.ipAddress,
                    invoiceId: self.dInvoiceId,
                    milestoneIds: self.milestoneIds,
                }).then(function(res){
                    $('#success-confirmation').modal('show');
                    self.resetForm();
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
            showErrorModal() {
                $('#debit-payment-errors-modal').modal('show');
            },
            resetForm() {
                this.deviceId = '';
                this.ipAddress = '';
                this.dInvoiceId = dUserInvoiceId;
                this.authToken = '';
                this.bankName = '';
                this.accountName = '';
                this.routingNumber = '';
                this.accountNumber = '';
                this.accountType = 'savings';
                this.holderType = 'personal';
                this.milestoneIds = [];
                this.errors = null;
                this.stopLoader();
            },
        }
    });
</script>
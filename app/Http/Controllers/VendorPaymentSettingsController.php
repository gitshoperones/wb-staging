<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Contracts\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PaymentGatewayIdGenerator;
use App\Http\Requests\StoreVendorPaymentSettingsRequest;
use App\Helpers\RedactInfo;

class VendorPaymentSettingsController extends Controller
{
    private $paymentGateway;
    private $gatewayUserId;
    private $loggedInUser;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store(StoreVendorPaymentSettingsRequest $request)
    {
        if(app('impersonate')->isImpersonating()) {
            $this->loggedInUser = Auth::user();
            
            $vendorProfile = $this->loggedInUser->vendorProfile;

            $vendorProfile->street = $request->street;
            $vendorProfile->city = $request->city;
            $vendorProfile->state = $request->state;
            $vendorProfile->postcode = $request->postcode;
            $vendorProfile->save();
        }else {
            Auth::user()->update([
                'dob' => $request->dob,
            ]);

            $this->loggedInUser = Auth::user();

            $vendorProfile = $this->loggedInUser->vendorProfile;

            if($request->bank && $request->accnt_name && $request->accnt_num && $request->bsb) {
                $paymentGatewayAccount = $this->loggedInUser->paymentGatewayUser;

                if (!$paymentGatewayAccount) {
                    $gatewayUser = $this->createPaymentGatewayUser($request->all());
                    $this->gatewayUserId = $gatewayUser['id'];
                } else {
                    $this->gatewayUserId = $paymentGatewayAccount->gateway_user_id;
                    $gatewayUser = $this->updatePaymentGatewayUser($request->all());
                }

                if (!$this->loggedInUser->vendorProfile->fee()->first()) {
                    $this->setupVendorFee();
                }

                if (!$paymentGatewayAccount || !$paymentGatewayAccount->gateway_company_id) {
                    $gatewayCompany = $this->createPaymentGatewayCompany($request->all());
                } else {
                    $gatewayCompany = $this->updatePaymentGatewayCompany($paymentGatewayAccount->gateway_company_id, $request->all());
                }
                
                $gatewayBankAccount = $this->createPaymentGatewayBankAccount($request->all());

                $this->paymentGateway->setDisbursementAccount($this->gatewayUserId, $gatewayBankAccount['id']);

                $this->loggedInUser->paymentGatewayUser()->updateOrCreate(
                    ['gateway_user_id' => $this->gatewayUserId],
                    [
                        'gateway_bank_acct_id' => $gatewayBankAccount['id'],
                        'gateway_company_id' => $gatewayCompany['id'],
                        'gateway_name' => config('paymentgateway.paymentGatewayName'),
                    ]
                );
                
                $redacted_request = (new RedactInfo)->redactInfo($request->only([
                    'bank', 'accnt_num', 'accnt_name', 'bsb', 'accnt_type', 'holder_type',
                ]) + ['status' => 1, 'country' => 'Australia']);
            }else {
                $redacted_request = $request->only([
                    'accnt_type', 'holder_type',
                ]) + ['status' => 1, 'country' => 'Australia'];
            }

            $vendorProfile->street = $request->street;
            $vendorProfile->city = $request->city;
            $vendorProfile->state = $request->state;
            $vendorProfile->postcode = $request->postcode;
            $vendorProfile->gst_registered = $request->gst_registered;
            $vendorProfile->save();

            $vendorProfile->paymentSetting()->updateOrCreate(
                ['vendor_id' => $vendorProfile->id],
                $redacted_request
            );
        }

        return redirect()->back()->with('success_message', 'Updated successfully!');
    }

    public function createPaymentGatewayUser($request)
    {
        return $this->paymentGateway->createUser([
            'id' => PaymentGatewayIdGenerator::generate($this->loggedInUser->id),
            'email' => $this->loggedInUser->email,
            'first_name' => $this->loggedInUser->fname,
            'last_name' => $this->loggedInUser->lname,
            'dob' => $this->loggedInUser->dob->format('d/m/Y'),
            'address_line1' => $request['street'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zip' => $request['postcode'],
            'country' => 'AUS'
        ]);
    }

    public function updatePaymentGatewayUser($request)
    {
        return $this->paymentGateway->updateUser(
            $this->gatewayUserId,
            [
                'email' => $this->loggedInUser->email,
                'first_name' => $this->loggedInUser->fname,
                'last_name' => $this->loggedInUser->lname,
                'dob' => $this->loggedInUser->dob->format('d/m/Y'),
                'address_line1' => $request['street'],
                'city' => $request['city'],
                'state' => $request['state'],
                'zip' => $request['postcode'],
                'country' => 'AUS'
            ]
        );
    }

    public function createPaymentGatewayCompany($request)
    {
        $vendor = $this->loggedInUser->vendorProfile;

        return $this->paymentGateway->createCompany([
            'user_id' => $this->gatewayUserId,
            'name' => $vendor->business_name,
            'legal_name' => $vendor->business_name,
            'tax_number' => $vendor->abn,
            'charge_tax' => $request['gst_registered'] == 1 ? 'true' : 'false',
            'phone' => $this->loggedInUser->phone_number,
            'address_line1' => $request['street'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zip' => $request['postcode'],
            'country' => 'AUS'
        ]);
    }

    public function updatePaymentGatewayCompany($gatewayCompanyId, $request)
    {
        $vendor = $this->loggedInUser->vendorProfile;

        return $this->paymentGateway->updateCompany(
            $gatewayCompanyId,
            [
                'user_id' => $this->gatewayUserId,
                'name' => $vendor->business_name,
                'legal_name' => $vendor->business_name,
                'tax_number' => $vendor->abn,
                'charge_tax' => $request['gst_registered'] == 1 ? 'true' : 'false',
                'phone' => $this->loggedInUser->phone_number,
                'address_line1' => $request['street'],
                'city' => $request['city'],
                'state' => $request['state'],
                'zip' => $request['postcode'],
                'country' => 'AUS'
            ]
        );
    }

    public function createPaymentGatewayBankAccount($request)
    {
        return $this->paymentGateway->createBankAccount([
            'user_id'   => $this->gatewayUserId,
            'bank_name' => $request['bank'],
            'account_name' => $request['accnt_name'],
            'routing_number' => $request['bsb'],
            'account_number' => $request['accnt_num'],
            'account_type' => $request['accnt_type'],
            'holder_type' => $request['holder_type'],
            'country' => 'AUS',
        ]);
    }

    public function setupVendorFee()
    {
        $fee = Fee::where('type', 'default')->where('status', 1)->firstOrFail();

        return $this->loggedInUser->vendorProfile->fee()->create(['fee_id' => $fee->id]);
    }
}

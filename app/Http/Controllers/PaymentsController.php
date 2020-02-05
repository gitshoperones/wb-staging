<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\User;
use App\Models\Media;
use App\Models\Vendor;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\VendorFee;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use App\Models\ErrorMessages;
use App\Contracts\PaymentGateway;
use App\Events\CoupleSentPayment;
use App\Models\JobQuoteMilestone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Helpers\PaymentGatewayIdGenerator;
use App\Http\Requests\StorePaymentRequest;
use App\Events\AdminConfirmedBooking;

class PaymentsController extends Controller
{
    private $paymentGateway;
    private $loggedInUser;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function create()
    {
        $invoice = Invoice::whereId(request('invoice_id'))->with([
            'jobQuote' => function ($q) {
                $q->with([
                    'milestones',
                    'jobPost' => function ($q) {
                        $q->with([
                            'category' => function ($q) {
                                $q->addSelect(['id', 'name']);
                            },
                            'locations' => function ($q) {
                                $q->addSelect(['locations.id', 'name']);
                            },
                            'userProfile' => function ($q) {
                                $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                            }
                        ]);
                    }
                ]);
            },
            'vendor' => function ($q) {
                $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
            },
        ])->firstOrFail();

        if ($invoice->status === 2) {
            abort(403, 'This invoice is already fully paid.');
        }

        if (Gate::denies('pay-invoice', $invoice)) {
            abort(403);
        }

        $gallery = Media::where('commentable_id', $invoice->jobQuote->jobPost->id)
            ->where('commentable_type', get_class($invoice->jobQuote->jobPost))
            ->where('meta_key', 'jobPostGallery')
            ->get(['meta_filename']);

        $errorMessages = ErrorMessages::all();

        return view('payments.create', compact('invoice', 'errorMessages', 'gallery'));
    }

    public function store(StorePaymentRequest $request)
    {
        $this->loggedInUser = Auth::user();

        $invoice = Invoice::whereId($request->invoiceId)->with([
            'couple', 'vendor'
        ])->firstOrFail();

        if (Gate::denies('pay-invoice', $invoice)) {
            abort(403);
        }

        if ($request->useSavedCard && $request->useSavedCard === true) {
            $valid = $this->validateCreditCard($request->all());

            if (!$valid) {
                return response()->json('Expiry Date does not matched!', 401);
            }
        }

        $jobQuoteMilestones = JobQuoteMilestone::whereIn('id', $request->milestoneIds)
            ->where('job_quote_id', $invoice->job_quote_id)->where('paid', 0)->get();
        $totalAmountInCents = $this->computeTotalAmountInCents($jobQuoteMilestones, $invoice->total);

        // Get the vendor Fee ID.
        $fee = $invoice->jobQuote->user->vendorProfile->feeDetails();
        $feeId = $fee->gateway_fee_id;
        // Get the gateway user ID of the user (couple) who is paying the invoice;
        $buyerGatewayId = $invoice->jobQuote->jobPost->user->paymentGatewayUser->gateway_user_id;
        // Get the gateway user ID of the user (vendor/business) who will receive the payment;
        $sellerGatewayId = $invoice->jobQuote->user->paymentGatewayUser->gateway_user_id;
        $descriptor = sprintf('wedbooker - %s', ucfirst($invoice->jobQuote->jobPost->category->name));

        $createItemResponse = $this->paymentGateway->createItem([
            'id' => PaymentGatewayIdGenerator::generate($this->loggedInUser->id),
            'name' => $descriptor,
            'buyer_id' => $buyerGatewayId,
            'seller_id' => $sellerGatewayId,
            'amount' => $totalAmountInCents,
            'payment_type' => 2,
            'fee_ids' => $feeId,
            'custom_descriptor' => $descriptor,
        ]);

        if ($request->modeOfPayment && $request->modeOfPayment === 'directDebit') {
            $this->paymentGateway->createDirectDebitAuthority([
                'account_id' => $request->cardAccountId,
                'amount' => $totalAmountInCents,
            ]);
        }

        try {
            $makePaymentResponse = $this->paymentGateway->makePayment(
                $createItemResponse['id'],
                [
                    'account_id' => $request->cardAccountId,
                    'ip_address ' => $request->ipAddresss,
                    'device_id ' => $request->deviceId,
                ]
            );
        } catch (Exception $e) {
            return 'message is: '. $e->getMessage();
        }

        $feeAmount = ($fee->amount / 100) * ($makePaymentResponse['amount'] / 100);
        $totalTax = ($this->getMilestoneTotalPercent($jobQuoteMilestones) * $invoice->amount) * .10;

        $payment = $this->loggedInUser->payments()->create([
            'amount' => $makePaymentResponse['amount'] / 100,
            'fee' => $feeAmount,
            'tax' => $totalTax,
            'api_response_id' => $makePaymentResponse['id'],
            'invoice_id' => $invoice->id,
            'milestone_ids' => $jobQuoteMilestones->pluck('id')->toArray()
        ]);
        
        event(new AdminConfirmedBooking()); # (optional) Move this to SendPaymentNotification.php
        // event(new AdminConfirmedBooking($payment));
        event(new CoupleSentPayment($payment));
        
        if ($request->saveCC) {
            $this->loggedInUser->cardAccounts()->create([
                'gateway_user_id' => $buyerGatewayId,
                'card_account_id' => $request->cardAccountId
            ]);
        }

        return response()->json([
            'id' => $payment->id,
            'api_response_id' => $payment->api_response_id,
            'amount' => $payment->amount,
            'fee' => $payment->fee,
            'tax' => $payment->tax,
        ]);
    }

    private function computeTotalAmountInCents($jobQuoteMilestones, $totalInvoice)
    {
        $amount = $this->getMilestoneTotalPercent($jobQuoteMilestones) * $totalInvoice;

        return $amount * 100;
    }

    public function getMilestoneTotalPercent($jobQuoteMilestones)
    {
        $percent = 0;

        foreach ($jobQuoteMilestones as $milestone) {
            $percent += $milestone->percent / 100;
        }

        return $percent;
    }

    public function validateCreditCard($request)
    {
        $cardAccount = $this->paymentGateway->getCreditCardDetails($request['cardAccountId']);


        if ((int) $request['expMonth'] !== (int) $cardAccount['card']['expiry_month']) {
            return false;
        }

        if ('20'.$request['expYear'] !== $cardAccount['card']['expiry_year']) {
            return false;
        }

        return true;
    }

    public function show()
    {
        $vendor = Vendor::where('id', request()->v)->first()['business_name'];
        
        $pageSettings = PageSetting::fromPage('Homepage')->get();
        return view('payments.thanks', compact('pageSettings', 'vendor'));
    }
}

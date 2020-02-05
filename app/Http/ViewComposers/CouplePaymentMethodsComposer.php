<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\UserCardAccount;
use App\Contracts\PaymentGateway;
use Illuminate\Support\Facades\Auth;

class CouplePaymentMethodsComposer
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function compose(View $view)
    {
        $gatewayUser = Auth::user()->paymentGatewayUser;
        if (!$gatewayUser) {
            return $view->with('creditCards', []);
        }

        $creditCards = UserCardAccount::where('gateway_user_id', $gatewayUser->gateway_user_id)
            ->get(['id', 'card_account_id']);

        foreach ($creditCards as $key => $card) {
            $cardDetails = $this->paymentGateway->getCreditCardDetails($card->card_account_id);
            if ($cardDetails) {
                $creditCards[$key]['card'] = $cardDetails['card'];
            }
        }

        return $view->with('creditCards', $creditCards);
    }
}

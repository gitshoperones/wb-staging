<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PaymentGatewayIdGenerator;

class PaymentGatewayAuthTokenController extends Controller
{
    public function store(Request $request, PaymentGateway $paymentGateway)
    {
        $user = Auth::user();

        $paymentGatewayUser = $user->paymentGatewayUser;

        if (!$paymentGatewayUser) {
            $paymentGatewayId = PaymentGatewayIdGenerator::generate($user->id);

            // create new user in the payment gateway
            $gatewayUser = $paymentGateway->createUser([
                'id' => $paymentGatewayId,
                'email' => $user->email,
                'first_name' => $user->fname,
                'last_name' => $user->lname,
                'country' => 'AUS'
            ]);

            // store payment gateway user in the database
            $paymentGatewayUser = $user->paymentGatewayUser()->create([
                'gateway_user_id' => $gatewayUser['id'],
                'gateway_name' => config('paymentgateway.paymentGatewayName'),
            ]);
        }

        $card = $paymentGateway->createCardToken(
            $paymentGatewayUser->gateway_user_id,
            $request->type ?: 'card'
        );

        return response()->json($card);
    }
}

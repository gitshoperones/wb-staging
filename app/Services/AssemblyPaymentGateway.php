<?php

namespace App\Services;

use PromisePay\PromisePay;
use App\Contracts\PaymentGateway;

class AssemblyPaymentGateway implements PaymentGateway
{
    public function __construct($env, $email, $token)
    {
        PromisePay::Configuration()->environment($env);
        PromisePay::Configuration()->login($email);
        PromisePay::Configuration()->password($token);
    }

    /**
     * Get credit card details from the payment gateway database.
     *
     * @param string $creditCardId
     * @return mixed
     */
    public function getCreditCardDetails($creditCardId)
    {
        return PromisePay::CardAccount()->get($creditCardId);
    }

    /**
     * Delete a card account from the payment gateway database.
     *
     * @param string $creditCardId
     * @return mixed
     */
    public function deleteCardAccount($creditCardId)
    {
        return PromisePay::CardAccount()->delete($creditCardId);
    }

    /**
     * Store new user account in the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function createUser($param)
    {
        return PromisePay::User()->create($param);
    }

    /**
     * Update user account in the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function updateUser($userId, $param)
    {
        return PromisePay::User()->update($userId, $param);
    }

    /**
     * Create new company in the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function createCompany($param)
    {
        return PromisePay::Company()->create($param);
    }

    /**
     * Update company in the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function updateCompany($companyId, $param)
    {
        return PromisePay::Company()->update($companyId, $param);
    }

    /**
     * Create new bank account in the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function createBankAccount($param)
    {
        return PromisePay::BankAccount()->create($param);
    }

    /**
     * Create new token that can be use to communicate with the payment gateway.
     *
     * @param string $userGatewayId
     * @param string $type
     * @return mixed
     */
    public function createCardToken($userGatewayId, $type = 'card')
    {
        return PromisePay::Token()->generateCardToken([
            'token_type' => $type,
            'user_id' => $userGatewayId
        ]);
    }

    /**
     * Create Item.
     *
     * @param array $param
     * @return mixed
     */
    public function createItem($param)
    {
        return PromisePay::Item()->create($param);
    }

    /**
     * Process payment for an item.
     *
     * @param string $itemId
     * @param array $param
     * @return mixed
     */
    public function makePayment($itemId, $param)
    {
        return PromisePay::Item()->makePayment($itemId, $param);
    }

    /**
     * Create a fee.
     *
     * @param array $param
     * @return mixed
     */
    public function createFee($param)
    {
        return PromisePay::Fee()->create([
            "name"        => $param['name'],
            "fee_type_id" => $param['fee_type_id'],
            "amount"      => $param['amount'],
            "cap"         => $param['cap'] ?? '',
            "min"         => $param['min'] ?? '',
            "max"         => $param['max'] ?? '',
            "to"          => $param['payer']
        ]);
    }

    /**
     * Create direct debit authority.
     *
     * @param array $param
     * @return mixed
     */
    public function createDirectDebitAuthority($param)
    {
        return PromisePay::DirectDebitAuthority()->create($param);
    }

    /**
     * Set user disbursement account.
     *
     * @param string $userGatewayId
     * @param string $bankAccountId
     * @return mixed
     */
    public function setDisbursementAccount($userGatewayId, $bankAccountId)
    {
        return PromisePay::User()->setDisbursementAccount($userGatewayId, array(
            'account_id' => $bankAccountId
        ));
    }
}

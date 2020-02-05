<?php

namespace App\Contracts;

interface PaymentGateway
{
    /**
     * Get credit card details from the payment gateway database.
     *
     * @param string $creditCardId
     * @return mixed
     */
    public function getCreditCardDetails($creditCardId);

    /**
     * Delete a card account from the payment gateway database.
     *
     * @param string $creditCardId
     * @return mixed
     */
    public function deleteCardAccount($creditCardId);

    /**
     * Create new user account in the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function createUser($param);

    /**
     * Update user account in the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function updateUser($userId, $param);

    /**
     * Create new company into the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function createCompany($param);

    /**
     * Create new bank account into the payment gateway database.
     *
     * @param array $param
     * @return mixed
     */
    public function createBankAccount($param);

    /**
     * Create new token that can be use to communicate with the payment gateway.
     *
     * @param string $userGatewayId
     * @param string $type
     * @return mixed
     */
    public function createCardToken($userGatewayId, $type);

    /**
     * Create item.
     *
     * @param array $param
     * @return mixed
     */
    public function createItem($param);

    /**
     * Make payment to Item.
     *
     * @param string $itemId
     * @param array $param
     * @return mixed
     */
    public function makePayment($itemId, $param);

    /**
     * Create a fee.
     *
     * @param array $param
     * @return mixed
     */
    public function createFee($param);

    /**
     * Create direct debit authority.
     *
     * @param array $param
     * @return mixed
     */
    public function createDirectDebitAuthority($param);

    /**
     * Set user disbursement account.
     *
     * @param string $userGatewayId
     * @param string $bankAccountId
     * @return mixed
     */
    public function setDisbursementAccount($userGatewayId, $bankAccountId);
}

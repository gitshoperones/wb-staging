<?php

namespace App\Helpers;

class PaymentGatewayIdGenerator
{
    public static function generate($userId)
    {
        $randomletters = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 10);

        return sprintf('%s%s%s', $userId, $randomletters, time());
    }
}

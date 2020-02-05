<?php

use Illuminate\Database\Seeder;

class ErrorMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $errorMessages = collect([
            [
                'code' => 601,
                'original_message' => 'Account must belong to the user',
                'custom_message' => 'Your payment has been declined. Error code 601',
            ],
            [
                'code' => 602,
                'original_message' => 'Account ID: invalid format',
                'custom_message' => 'Your payment has been declined. Error code 602',
            ],
            [
                'code' => 604,
                'original_message' => 'Action is invalid, state transition invalid',
                'custom_message' => 'Your payment has been declined. Error code 604',
            ],
            [
                'code' => 606,
                'original_message' => 'Credit card payment failed: Invalid billing descriptor',
                'custom_message' => 'Your payment has been declined. Error code 606',
            ],
            [
                'code' => 607,
                'original_message' => 'Credit card payment failed: Do Not Honor',
                'custom_message' => 'Your payment has been declined. Error code 607',
            ],
            [
                'code' => 608,
                'original_message' => 'Credit card payment failed: Refer to Card Issuer',
                'custom_message' => 'Your payment has been declined. Error code 608',
            ],
            [
                'code' => 609,
                'original_message' => 'Credit card authorization failed: Unable to communicate with the payment system',
                'custom_message' => 'Your payment has been declined. Error code 609',
            ],
            [
                'code' => 610,
                'original_message' => 'Credit card authorization failed: The payment gateway is currently unavailable.',
                'custom_message' => 'Your payment has been declined. Error code 610',
            ],
            [
                'code' => 611,
                'original_message' => 'Credit card authorization failed: Refer to card issuer',
                'custom_message' => 'Your payment has been declined. Error code 611',
            ],
            [
                'code' => 612,
                'original_message' => 'Credit card authorization failed: Unable to process the purchase transaction',
                'custom_message' => 'Your payment has been declined. Error code 612',
            ],
            [
                'code' => 618,
                'original_message' => 'Credit card refund failed: Stolen card, pick up',
                'custom_message' => 'Your payment has been declined. Error code 618',
            ],
            [
                'code' => 613,
                'original_message' => 'User currently held and not permitted to actively transact',
                'custom_message' => 'Your payment has been declined. Error code 613',
            ],
            [
                'code' => 619,
                'original_message' => 'You cannot pay via direct debit without authority',
                'custom_message' => 'Your payment has been declined. Error code 619',
            ],
            [
                'code' => 620,
                'original_message' => 'You cannot transact across different currencies',
                'custom_message' => 'Your payment has been declined. Error code 620',
            ],
            [
                'code' => 621,
                'original_message' => 'You cannot pay by credit card for this transaction.',
                'custom_message' => 'Your payment has been declined. Error code 621',
            ],
            [
                'code' => 622,
                'original_message' => 'You cannot pay by direct debit for this transaction.',
                'custom_message' => 'Your payment has been declined. Error code 622',
            ],
            [
                'code' => 623,
                'original_message' => 'You cannot pay by digital wallet for this transaction.',
                'custom_message' => 'Your payment has been declined. Error code 623',
            ],
            [
                'code' => 624,
                'original_message' => 'You cannot pay by wire transfer for this transaction.',
                'custom_message' => 'Your payment has been declined. Error code 624',
            ],
            [
                'code' => 614,
                'original_message' => 'Error processing credit card. If this error persists, please contact our support team.',
                'custom_message' => 'Your payment has been declined. Error code 614',
            ],
            [
                'code' => 625,
                'original_message' => 'Action not available for items with completed state',
                'custom_message' => 'Your payment has been declined. Error code 625',
            ],
            [
                'code' => 626,
                'original_message' => 'Partial refunds are not allowed.',
                'custom_message' => 'Your payment has been declined. Error code 626',
            ],
            [
                'code' => 630,
                'default' => 1,
                'original_message' => null,
                'custom_message' => 'Your payment has been declined. Error code 630',
            ],
        ])->reduce(function ($lists, $item) {
            $lists[] = [
                'code' => $item['code'],
                'default' => $item['default'] ?? null,
                'original_message' => $item['original_message'],
                'custom_message' => $item['custom_message'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $lists;
        });

        DB::table('error_messages')->insert($errorMessages);
    }
}

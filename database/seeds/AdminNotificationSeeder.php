<?php

use Illuminate\Database\Seeder;

class AdminNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = collect([
            [ //Draft Job Reminder - Couple
                'notification_event_id' => 1,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'New admin user created',
                'body' => '
                    <p>Email: [email]</p>
                    <p>First Name: [first_name]</p>
                    <p>Last Name: [last_name]</p>
                ',
                'button' => null,
                'button_link' => null,
                'recipient' => 'super_admin',
                'tokens_subject' => null,
                'tokens_body' => '[first_name],[last_name],[email]',
                'type' => 'email'
            ],
            [ //Draft Job Reminder - Couple
                'notification_event_id' => 8,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'New Job Quote Submitted',
                'body' => '
                    <p>Vendor Name: [vendor_name]</p>
                    <p>Title: [couple_title]</p>
                    <p>Amount: [amount]</p>
                    <p>Total: [total]</p>
                    <p>Date Submitted: [created_at]</p>
                ',
                'button' => null,
                'button_link' => null,
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[vendor_name],[couple_title],[amount],[total],[created_at]',
                'type' => 'email'
            ],
            [ //Draft Job Reminder - Couple
                'notification_event_id' => 38,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Job Quote Accepted',
                'body' => '
                    <p>Vendor Name: [vendor_name]</p>
                    <p>Title: [couple_title]</p>
                    <p>Amount: [amount]</p>
                    <p>Total: [total]</p>
                ',
                'button' => null,
                'button_link' => null,
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[vendor_name],[couple_title],[amount],[total]',
                'type' => 'email'
            ],
            [ //Balance Paid - Couple
                'notification_event_id' => 23,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Balance Paid',
                'body' => '
                    <p>[couple_title] paid in full to [business_name]</p>
                ',
                'button' => null,
                'button_link' => null,
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[couple_title],[business_name]',
                'type' => 'email'
            ],
        ])->reduce(function ($lists, $list) {
            $lists[] = [
                'notification_event_id' => $list['notification_event_id'],
                'email_template_id' => $list['email_template_id'],
                'frequency' => $list['frequency'],
                'subject' => $list['subject'],
                'body' => $list['body'],
                'button' => $list['button'],
                'button_link' => $list['button_link'],
                'recipient' => $list['recipient'],
                'tokens_subject' => $list['tokens_subject'],
                'tokens_body' => $list['tokens_body'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'type' => $list['type'],
            ];

            return $lists;
        });

        DB::table('email_notifications')->insert($lists);
    }
}

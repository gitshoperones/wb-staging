<?php

use Illuminate\Database\Seeder;
use Illuminate\Queue\Failed\NullFailedJobProvider;

class JobQuoteResubmittedNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = collect([
            [
                'name' => 'Job Quote Resubmitted',
                'type' => '',
                'description' => 'Sent when a couple has a draft job post for 2 days',
                'order' => 56
            ],//56 - done
        ])->reduce(function ($events, $event) {
            $events[] = [
                'name' => $event['name'],
                'description' => $event['description'],
                'type' => $event['type'],
                'order' => $event['order'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $events;
        });

        DB::table('notification_events')->insert($events);
        
        $lists = collect([
            [ //Job Quote Resubmitted - Vendor
                'notification_event_id' => 56,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your quote has been re-submitted.',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your job has been re-submitted. We\'ll let you know when they respond.
                    </p>
                ',
                'button' => 'View Job Quote',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ]
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

        $lists = collect([
            [ //Draft Job Post - Couple
                'notification_event_id' => 56,
                'frequency' => 'realtime,summary',
                'subject' => 'Your quote has been re-submitted.',
                'body' => 'Your job has been re-submitted. We\'ll let you know when they respond.',
                'button' => 'View Job Quote',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'dashboard'
            ],
        ])->reduce(function ($lists, $list) {
            $lists[] = [
                'notification_event_id' => $list['notification_event_id'],
                'frequency' => $list['frequency'],
                'subject' => $list['subject'],
                'body' => $list['body'],
                'button' => $list['button'],
                'button_link' => $list['button_link'],
                'button2' => isset($list['button2']) ? $list['button2'] : null,
                'button_link2' => isset($list['button_link2']) ? $list['button_link2'] : null, 
                'recipient' => $list['recipient'],
                'tokens_subject' => $list['tokens_subject'],
                'tokens_body' => $list['tokens_body'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'type' => $list['type'],
            ];

            return $lists;
        });

        DB::table('dashboard_notifications')->insert($lists);
    }
}

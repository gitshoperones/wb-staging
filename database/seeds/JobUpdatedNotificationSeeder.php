<?php

use Illuminate\Database\Seeder;
use Illuminate\Queue\Failed\NullFailedJobProvider;

class JobUpdatedNotificationSeeder extends Seeder
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
                'name' => 'Job Updated',
                'type' => '',
                'description' => 'When a couple edits their job post, businesses are sent a notification',
                'order' => 55
            ],//55 - done
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
            [ //Job Updated - Vendor
                'notification_event_id' => 55,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_name] have updated their [category] job.',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        They have added more details to their job in case it\'s of interest to you!
                    </p>
                ',
                'button' => 'View Job',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_name],[category]',
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
                'notification_event_id' => 55,
                'frequency' => 'realtime,summary',
                'subject' => '[couple_name] have updated their [category] job.',
                'body' => 'They have added more details to their job in case it\'s of interest to you!',
                'button' => 'View Job',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_name],[category]',
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

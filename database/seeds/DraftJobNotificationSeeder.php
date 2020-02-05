<?php

use Illuminate\Database\Seeder;
use Illuminate\Queue\Failed\NullFailedJobProvider;

class DraftJobNotificationSeeder extends Seeder
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
                'name' => 'Draft Job Reminder',
                'type' => '',
                'description' => 'Sent when a couple has a draft job post for 2 days',
                'order' => 54
            ],//54 - done
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
            [ //Draft Job Reminder - Couple
                'notification_event_id' => 54,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Finish your draft job post.',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your job has been saved in draft for 2 days. Finish your job post to start receiving quotes from businesses.
                    </p>
                ',
                'button' => 'Login To View Job',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Draft Job Reminder - Admin
                'notification_event_id' => 54,
                'email_template_id' => 1,
                'frequency' => 'realtime',
                'subject' => 'A draft job post is to be completed',
                'body' => '
                    <h1>Job Details</h1>
                    <p></p>
                    <p>Couple: [user_profile_title]</p>
                    <p>Email: [user_email]</p>
                    <p>Category: [category_name]</p>
                    <p>Event Type: [event_name]</p>
                    <p>Locations: [location]</p>
                    <p>Event Date: [event_date]</p>
                    <p>Created Date: [created_at]</p>
                    <p>Job Expiry: [updated_at]</p>
                    <p>Job Type: [job_type]</p>
                ',
                'button' => '',
                'button_link' => null,
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[user_profile_title],[user_email],[category_name],[event_name],[location],[event_date],[created_at],[updated_at],[job_type]',
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

        $lists = collect([
            [ //Draft Job Post - Couple
                'notification_event_id' => 54,
                'frequency' => 'realtime,summary',
                'subject' => 'Finish your draft job post.',
                'body' => 'Your job has been saved in draft for 2 days. Finish your job post to start receiving quotes from businesses.',
                'button' => 'Finish Job',
                'button_link' => null,
                'recipient' => 'couple',
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

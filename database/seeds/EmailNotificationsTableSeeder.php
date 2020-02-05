<?php

use Illuminate\Database\Seeder;
use Illuminate\Queue\Failed\NullFailedJobProvider;

class EmailNotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = collect([
            ['name' => 'admin', 'content' => ''],
            ['name' => 'main', 'content' => '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400" rel="stylesheet">
                    <title>%email_title%</title>
                    <style>
                
                        /* cyrillic-ext */
                        @font-face {
                            font-family: "Ubuntu";
                            font-style: normal;
                            font-weight: 300;
                            src: local("Ubuntu Light"), local("Ubuntu-Light"), url(https://fonts.gstatic.com/s/ubuntu/v11/4iCv6KVjbNBYlgoC1CzjvWyNL4U.woff2) format("woff2");
                            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
                        }
                        /* cyrillic */
                        @font-face {
                            font-family: "Ubuntu";
                            font-style: normal;
                            font-weight: 300;
                            src: local("Ubuntu Light"), local("Ubuntu-Light"), url(https://fonts.gstatic.com/s/ubuntu/v11/4iCv6KVjbNBYlgoC1CzjtGyNL4U.woff2) format("woff2");
                            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
                        }
                        /* greek-ext */
                        @font-face {
                            font-family: "Ubuntu";
                            font-style: normal;
                            font-weight: 300;
                            src: local("Ubuntu Light"), local("Ubuntu-Light"), url(https://fonts.gstatic.com/s/ubuntu/v11/4iCv6KVjbNBYlgoC1CzjvGyNL4U.woff2) format("woff2");
                            unicode-range: U+1F00-1FFF;
                        }
                        /* greek */
                        @font-face {
                            font-family: "Ubuntu";
                            font-style: normal;
                            font-weight: 300;
                            src: local("Ubuntu Light"), local("Ubuntu-Light"), url(https://fonts.gstatic.com/s/ubuntu/v11/4iCv6KVjbNBYlgoC1Czjs2yNL4U.woff2) format("woff2");
                            unicode-range: U+0370-03FF;
                        }
                        /* latin-ext */
                        @font-face {
                            font-family: "Ubuntu";
                            font-style: normal;
                            font-weight: 300;
                            src: local("Ubuntu Light"), local("Ubuntu-Light"), url(https://fonts.gstatic.com/s/ubuntu/v11/4iCv6KVjbNBYlgoC1CzjvmyNL4U.woff2) format("woff2");
                            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                        }
                        /* latin */
                        @font-face {
                            font-family: "Ubuntu";
                            font-style: normal;
                            font-weight: 300;
                            src: local("Ubuntu Light"), local("Ubuntu-Light"), url(https://fonts.gstatic.com/s/ubuntu/v11/4iCv6KVjbNBYlgoC1CzjsGyN.woff2) format("woff2");
                            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                        }
                    </style>
                </head>
                <body style="background-color: #e7d8d1;padding: 60px 15px;text-align: center;font-weight: 300;font-family: "Ubuntu, sans-serif;line-height: 1.6em;">
                    <table class="container header" style="max-width: 600px; padding: 15px; margin: auto;background-color: #fff;width: 100%;margin: auto;-webkit-box-shadow: 0 0 3px 0 rgba(0,0,0,.1);box-shadow: 0 0 3px 0 rgba(0,0,0,.1);border-bottom: 1px solid #f1f1f1;">
                        <tr>
                            <td>
                                <table class="center fullwidth" style="width: 100%;text-align: center;">
                                    <tr>
                                        <td style="height: 15px;"> </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">
                                            <a href="{{ url("/") }}" style="text-decoration: none;"><span></span>
                                                <img style="max-width: 139px;" src="{{ asset("assets/images/logo-email.png") }}" alt="">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px;"> </td>
                                    </tr>
                                    <tr>
                                        <td class="line" style="border-bottom: 1px solid #f1f1f1;">
                                        </td>
                                    </tr>
                                </table>
                                <table class="fullwidth center" style="width: 100%;text-align: center;">
                                    <tr>
                                        <td style="text-align: left;">
                                            %email_body%
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="height: 15px;"> </td>

                        </tr><tr>
                        <td style="text-align: left;">
                            <a href="%email_button_link%" class="btn orange" style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;text-transform: uppercase;font-size: 14px;font-weight: 300;border-radius: 3px;padding: 11px 48px;background: #fe5e44;display: inline-block;color: #fff;">%email_button_text%</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 35px;"> </td>
                    </tr>
                </table>

                <!-- /.container -->
                <table>
                    <tr>
                        <td style="height: 10px;"></td>
                    </tr>
                </table>

                <table class="container fullwidth center bg-white" style="padding: 15px; max-width: 600px; margin: auto;background-color: #fff;width: 100%;margin: auto;-webkit-box-shadow: 0 0 3px 0 rgba(0,0,0,.1);box-shadow: 0 0 3px 0 rgba(0,0,0,.1);text-align: center;">
                    <tr>
                        <td style="height: 20px;"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">
                            <img style="max-width: 24px;" src="http://dev.wedbooker.com/assets/images/emails/envelope.png" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td class="font-xs" style="text-align: left; color: #656565;line-height: 1.4em;font-family: \'Ubuntu\', sans-serif;font-size: 12px;">
                            Have a question? Email us at  <br>
                            <a href="mailto:hello@wedbooker.com" style="color: #fe5e44;">hello@wedbooker.com</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 45px;"> </td>
                    </tr>
                    <tr>
                        <td class="social">
                            <table class="fullwidth center" style="width: 100%;text-align: center;">
                                <tr>
                                    <td style="text-align: left;">
                                        <a href="https://www.facebook.com/WedBooker/" target="_blank" style="text-decoration: none;padding: 7px; padding-left: 0">
                                            <img style="max-width: 29px;" src="http://dev.wedbooker.com/assets/images/emails/fb.png" alt="">
                                        </a>
                                        <a href="https://www.pinterest.com/wedbooker" target="_blank" style="text-decoration: none;padding: 7px;">
                                            <img style="max-width: 29px;" src="http://dev.wedbooker.com/assets/images/emails/pi.png" alt="">
                                        </a>
                                        <a href="https://www.instagram.com/wedbooker/" target="_blank" style="text-decoration: none;padding: 7px;">
                                            <img style="max-width: 29px;" src="http://dev.wedbooker.com/assets/images/emails/in.png" alt="">
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-sm" style="text-align: left; font-size: 14px;">
                            <p style="color: #434343; font-family: \'Ubuntu\', sans-serif;">Copyright &copy; {{ now()->year }} wedBooker Pty Ltd All Rights Reserved.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-sm center" style="text-align: left;font-size: 14px;">
                            <p style="margin: auto; color: #434343; font-family: \'Ubuntu\', sans-serif;">You are receiving this email because you have signed-up to <a href="{{ url("/") }}" style="color: #fe5e44;">wedBooker.com</a>.
                            </p>
                        </td>
                    </td>
                    <tr>
                        <td style="height: 10px;"></td>
                    </tr>
                    <tr>
                        <td class="footer-menu font-sm" style="text-align: left; font-size: 14px;">
                            <a style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554;" href="{{ url("/how-it-works") }}">How it Works</a> <span class="separator" style="color: #e0e0e0;">|</span>
                            <a style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554;" href="{{ url("/suppliers-and-venues") }}">Suppliers & Venues</a> <span class="separator" style="color: #e0e0e0;">|</span>
                            <a style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554;" href="https://wedbooker.com/inspiration">Blog</a> <span class="separator" style="color: #e0e0e0;">|</span>
                            <a style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554;" href="{{ url("/faqs") }}">FAQs</a> <span class="separator" style="color: #e0e0e0;">|</span>
                            <a style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554;" href="{{ url("/contact-us") }}">Contact Us</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 50px; font-family: \'Ubuntu\', sans-serif;"></td>
                    </tr>
                </table>
                </body>
                </html>'],
        ])->reduce(function ($templates, $template) {
            $templates[] = [
                'name' => $template['name'],
                'content' => $template['content'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            return $templates;
        });

        DB::table('email_templates')->insert($templates);
        
        $events = collect([
            [
                'name' => 'New Admin User',
                'type' => '',
                'description' => 'New admin account is created - invite to set a password',
                'order' => 1
            ],//1 - done
            [
                'name' => 'New User Sign Up',
                'type' => '',
                'description' => 'User is sent an email to verify their email address',
                'order' => 2
            ],//2 - done
            [
                'name' => 'Email Verified',
                'type' => '',
                'description' => 'After a user verifies their email, they are sent a dashboard and email notification',
                'order' => 3
            ],//3 - done
            [
                'name' => 'Password Reset',
                'type' => '',
                'description' => 'When a user needs to reset their password',
                'order' => 4
            ],//4 - done
            [
                'name' => 'New Job Request - Single',
                'type' => 'App\Notifications\NewJobPosted',
                'description' => 'Specific business is notified that a couple wants a quote from them',
                'order' => 5
            ],//5 - done
            [
                'name' => 'New Job Request - Multiple',
                'type' => 'App\Notifications\NewJobPosted',
                'description' => 'Specific and matching business is notified that a couple wants a quote from them',
                'order' => 6
            ],//6 - done
            [
                'name' => 'New Job Post',
                'type' => 'App\Notifications\NewJobPosted',
                'description' => 'A couple posted a job and is waiting approval of admin',
                'order' => 7
            ],//7 - done
            [
                'name' => 'New Job Quote',
                'type' => 'App\Notifications\JobQuoteReceived',
                'description' => 'Couple receives a new quote on one of their jobs',
                'order' => 8
            ],//8 - done
            [
                'name' => 'Account Approved',
                'type' => '',
                'description' => 'Business profile is approved',
                'order' => 9
            ],//9 - done
            [
                'name' => 'Booking Confirmed',
                'type' => '',
                'description' => 'Business is confirmed as the supplier/venue for a job',
                'order' => 10
            ],//10 - done
            [
                'name' => 'Payment Reminder',
                'type' => '',
                'description' => 'When a business send a payment reminder to couples, the couple will receive the notification',
                'order' => 11
            ],//11 - done
            [
                'name' => 'Payment Made',
                'type' => '',
                'description' => 'When the couple sent a payment, send an email notification of receipt.',
                'order' => 12
            ],//12
            [
                'name' => 'Booking Refunded',
                'type' => '',
                'description' => 'When the booking is marked as refunded by the admin, the business and couple will receive notification',
                'order' => 13
            ],//13
            [
                'name' => 'Account Summary',
                'type' => '',
                'description' => '',
                'order' => 14
            ],//14
            [
                'name' => 'Contact Form',
                'type' => '',
                'description' => 'User submits an enquiry via our contact form - email sent to hello@wedbooker.com',
                'order' => 15
            ],//15 - done
            [
                'name' => 'Delete Account Request',
                'type' => '',
                'description' => 'User asks us to close their account - email sent to hello@wedbooker.com',
                'order' => 16
            ],//16 - done
            [
                'name' => 'Offer Expired',
                'type' => '',
                'description' => 'Remind businesses a day after their exclusive offer has expired',
                'order' => 17
            ],//17 - done
            [
                'name' => 'Job Quote Expired',
                'type' => '',
                'description' => 'Quote expires (according to the date specified by the business in their quote)',
                'order' => 18
            ],//18 - done
            [
                'name' => 'Job Expired',
                'type' => '',
                'description' => 'Job expires - 12 weeks after posted',
                'order' => 19
            ],//19 - done
            [
                'name' => 'Review Received',
                'type' => '',
                'description' => 'Notify business when they received a review',
                'order' => 20
            ],//20
            [
                'name' => 'New Message Received',
                'type' => '',
                'description' => 'User receives a new message',
                'order' => 21
            ],//21 - done
            [
                'name' => 'Parent Account Created',
                'type' => '',
                'description' => 'Parent account created - invite to set a password',
                'order' => 22
            ],//22 - done
            [
                'name' => 'Balance Paid',
                'type' => '',
                'description' => 'When the couple paid the remaining balance for the event',
                'order' => 23
            ],//23
            [
                'name' => 'Booking Cancelled',
                'type' => '',
                'description' => 'When a booking is cancelled by the admin, the business and couple will receive notification',
                'order' => 24
            ],//24
            [
                'name' => 'Booking Date Reminder',
                'type' => '',
                'description' => 'Booking coming up soon - 30 days before event date',
                'order' => 25
            ],//25 - done
            [
                'name' => 'Job Post Expiration Reminder',
                'type' => '',
                'description' => 'Job post closing soon - 11 weeks after posted',
                'order' => 26
            ],//26 - done
            [
                'name' => 'Job Quote Expiration Reminder',
                'type' => '',
                'description' => '3 days before the quote expires',
                'order' => 27
            ],//27 - done
            [
                'name' => 'Send Afternoon Account Notification Summary',
                'type' => '',
                'description' => 'Sent every day at 4pm for users who have unread notifications and their notification settings on "daily summary" (no users given this option at the moment).',
                'order' => 28
            ],//28 - done
            [
                'name' => 'Send Morning Account Notification Summary',
                'type' => '', 
                'description' => 'Sent every morning at 6am for users who have unread notifications and their notification settings on "daily summary" (no users given this option at the moment).',
                'order' => 29
            ],//29 - done
            [
                'name' => 'Send Message Inbox Summary',
                'type' => '',
                'description' => 'Mondays and Fridays @ 11am to users with unread messages',
                'order' => 30
            ],//30 - done
            [
                'name' => 'Unread Notification',
                'type' => '',
                'description' => 'Sent every second Mondays @ 12pm for any users with unread notifications',
                'order' => 31
            ],//31 - done
            [
                'name' => 'Send Vendor Review To Couples',
                'type' => '',
                'description' => 'Asking couple to review a business after booking',
                'order' => 32
            ],//32 - done
            [
                'name' => 'Balance Due Reminder',
                'type' => '',
                'description' => 'Remind couples to pay balance 2 days ahead of due date',
                'order' => 33
            ],//33 - done
            [
                'name' => 'Invoice Received',
                'type' => '',
                'description' => 'Couple is notified that they have received the invoice',
                'order' => 34
            ],//34 - done
            [
                'name' => 'Invoice Sent',
                'type' => '',
                'description' => 'Business is notified that the invoice has been generated for the couples',
                'order' => 35
            ],//35 - done
            [
                'name' => 'Refund Requested by Couple',
                'type' => '',
                'description' => 'When a couple requests a refund',
                'order' => 36
            ],//36 - done
            [
                'name' => 'Job Quote Extended',
                'type' => '',
                'description' => 'When a business extends their quote',
                'order' => 37
            ],//37 - done
            [
                'name' => 'Job Quote Response - accepted',
                'type' => '',
                'description' => 'Couple accepted quote',
                'order' => 38
            ],//38 - done
            [
                'name' => 'Job Quote Response - request changes',
                'type' => '',
                'description' => 'Couple asked for changes with the quote',
                'order' => 39
            ],//39 - done
            [
                'name' => 'Job Quote Response - declined',
                'type' => '',
                'description' => 'Business notified that couple declined their quote',
                'order' => 40
            ],//40 - 
            [
                'name' => 'New Job Post - Favourite',
                'type' => '',
                'description' => 'Business notified if a job is posted and they are a favourite for that couple',
                'order' => 41
            ],//41 - done
            [
                'name' => 'New Job Approved',
                'type' => '',
                'description' => 'When the admin approved a job',
                'order' => 42
            ],//42 - done
            [
                'name' => 'Email Verified - Profile Picture',
                'type' => '',
                'description' => 'When a user verified their email, they received a dashboard notification to change their profile picture',
                'order' => 43
            ],//43 - done
            [
                'name' => 'Job Quote Updated',
                'type' => '',
                'description' => 'Couple receives an updated quote from the business',
                'order' => 44
            ],//44 - done
            [
                'name' => 'Email Verified - Review',
                'type' => '',
                'description' => 'When a vendor verified their email, they received a dashboard notification to invite couple to review them',
                'order' => 45
            ],//45 - done
            [
                'name' => 'New Favourite',
                'type' => '',
                'description' => 'When a couple added a business as favourite',
                'order' => 46
            ],//46 - done
            [
                'name' => 'Account Pending',
                'type' => '',
                'description' => 'Business profile is set to pending',
                'order' => 47
            ],//47 - done
            [
                'name' => 'Job Match Reminder',
                'type' => '',
                'description' => 'Notify business of the job matched with no quotes sent after 5 days',
                'order' => 48
            ],//48 - done
            [
                'name' => 'Job Quote Reminder',
                'type' => '',
                'description' => 'Notify couple of the job quote with no response sent after 5 days',
                'order' => 49
            ],//49 - done
            [
                'name' => 'Request For Review',
                'type' => '',
                'description' => 'Emails the couple the business has invited for them to review',
                'order' => 50
            ],//50 - done
            [
                'name' => 'Low Vendor Review',
                'type' => '',
                'description' => 'Send an email notification to admin when a business received a review below 3 stars',
                'order' => 51
            ],//51 - done
            [
                'name' => 'Refund Requested by Business',
                'type' => '',
                'description' => 'When a business issued a refund',
                'order' => 52
            ],//52 - done
            [
                'name' => 'Business First Qoute',
                'type' => '',
                'description' => 'When a business submits a quote for the first time and they have not setup their bank details',
                'order' => 53
            ],//53 - done
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
            [ //Business First Qoute - Vendor
                'notification_event_id' => 53,
                'email_template_id' => 2,
                'frequency' => 'realtime,summary',
                'subject' => 'Add your bank details to get paid promptly',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Thanks for quoting on your first job! When you have a minute to spare, add your bank details to your account settings to make sure you get paid promptly into your account for any work you win on wedBooker!</p>
                ',
                'button' => 'Add bank details',
                'button_link' => '/user-settings/payment',
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Request For Review - Email only
                'notification_event_id' => 51,
                'email_template_id' => 2,
                'frequency' => 'realtime,summary',
                'subject' => 'Low vendor review',
                'body' => '
                    <p>Business Name: [business_name]</p>
                    <p>Business Email: [business_email]</p>
                    <p><strong>Review Details</strong></p>
                    <p>Couple Title: [reviewer_name]</p>
                    <p>Event Type: [event_type]</p>
                    <p>Event Date: [event_date]</p>
                    <p><b><u><i>Average Rating From Couple: [average_rating]</i></u></b></p>
                    <p>Easy to work with: [easy_to_work_score] }}</p>
                    <p>Likely to recommend to a friend: [likely_to_recommend_score]</p>
                    <p>Overall Rating from Couple: [overall_satisfaction]</p>
                    <p><b>message: <i>[message]</i></b></p>
                ',
                'button' => null,
                'button_link' => null,
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[business_name],[business_email],[reviewer_name],[event_type],[event_date],[average_rating],[easy_to_work_score],[likely_to_recommend_score],[overall_satisfaction],[message]',
                'type' => 'email'
            ],
            [ //Request For Review - Email only
                'notification_event_id' => 50,
                'email_template_id' => 2,
                'frequency' => 'realtime,summary',
                'subject' => '[business_name] has asked you to review their business',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [reviewer_name],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        [business_name] has recently signed up on wedBooker, an awesome site where Aussie couples are planning their wedding.
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Since you have previously used their services, they have asked if you will kindly review their business, to help them build their star rating on wedBooker.
                        You can click the link below to leave a review for their business, and it only takes 2 minutes.
                    </p>
                ',
                'button' => 'I\'ll Review Them Now',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[reviewer_name],[business_name]',
                'type' => 'email'
            ],
            [ //New Admin User
                'notification_event_id' => 1,
                'email_template_id' => 2,
                'frequency' => 'realtime,summary',
                'subject' => 'You\'re invited to setup your wedBooker Admin Account',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You\'re invited to setup your wedBooker Admin Account. To finalise your account setup, please set your password now.
                    </p>
                ',
                'button' => 'Set My Password',
                'button_link' => null,
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //New User Sign Up
                'notification_event_id' => 2,
                'email_template_id' => 2,
                // 'frequency' => 'realtime,summary',
                'frequency' => 'realtime',
                'subject' => 'Verify your email address',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Thanks for signing up with wedBooker. Click the link below to verify your email address and complete your sign up.
                    </p>
                ',
                'button' => 'Verify Email',
                'button_link' => null,
                'recipient' => 'vendor,couple',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //New User Sign Up - Admin
                'notification_event_id' => 2,
                'email_template_id' => 1,
                // 'frequency' => 'realtime,summary',
                'frequency' => 'realtime',
                'subject' => 'New user just signed Up!',
                'body' => '
                    user type: [user_type]
                        <br/><br/>
                    email: [user_email]
                ',
                'button' => '',
                'button_link' => null,
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[user_type],[user_email],[user_fname],[user_lname]',
                'type' => 'email'
            ],
            [ //Email Verified - Couple
                'notification_event_id' => 3,
                'email_template_id' => 2,
                // 'frequency' => 'realtime,summary',
                'frequency' => 'realtime',
                'subject' => 'Welcome to WedBooker!',
                'body' => '
                    <h1 style="font-family: \'Ubuntu\', sans-serif;margin: 15px 0;font-size: 36px;font-weight: 300; line-height: normal;">Time to book your dream wedding events!<br></h1>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">We are so excited you\'ve chosen wedBooker to plan your wedding celebrations. Less time for stress, more time for bubbly! Let\'s get started... <br></p><p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">You have two options:<br></p><p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">1. Simply post a job with details of what you need for your events, and we will match you with the Suppliers &amp; Venues best suited to your needs! Or,<br></p><p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">2. Start browsing our incredible selection of Suppliers &amp; Venues, and you can request quotes directly from the ones you like best. </p><p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">While we have you, here\'s a quick tip. We highly recommend you download our <a href="https://www.wedbooker.com/planning-checklist" target="_blank">Planning Checklist</a> to help with your wedding planning. Plus, if you need any more help, you can always get in touch with us at <a href="http://hello@wedbooker.com" target="_blank">hello@wedbooker.com</a></p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Happy planning! <br><br> Laura and Belle xo <br>The wedBooker Co-Founders</p>
                ',
                'button' => 'Start Planning',
                'button_link' => '/dashboard',
                'recipient' => 'couple',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Email Verified - Vendor
                'notification_event_id' => 3,
                'email_template_id' => 2,
                // 'frequency' => 'realtime,summary',
                'frequency' => 'realtime',
                'subject' => 'Your account is being reviewed',
                'body' => '
                    <h1 style="font-family: \'Ubuntu\', sans-serif;margin: 15px 0;font-size: 36px;font-weight: 300; line-height: normal;">Thank you for signing up to wedBooker!</h1>

                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">We are excited to have received your application! wedBooker is a professional network of Suppliers & Venues. As such, your registration is currently undergoing review by a member of our team. We will be in touch shortly.</p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">In the meantime, you can setup your business profile to showcase the amazing work you do. Be sure to add lots of photos and a thorough description of your services as these will help you win more work.</p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Please feel free to reach out to us at <a href="mailto:hello@wedbooker.com">hello@wedbooker.com</a> if you have any questions.</p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Laura and Belle xo <br>The wedBooker Co-Founders </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;"></p>
                ',
                'button' => 'Setup My Profile',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Account Pending - Vendor
                'notification_event_id' => 47,
                'email_template_id' => 2,
                // 'frequency' => 'realtime,summary',
                'frequency' => 'realtime',
                'subject' => 'Your account is being reviewed',
                'body' => '
                    <h1 style="font-family: \'Ubuntu\', sans-serif;margin: 15px 0;font-size: 36px;font-weight: 300; line-height: normal;">Thank you for signing up to wedBooker!</h1>

                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">wedBooker is a professional network of Suppliers & Venues. As such, your registration is currently undergoing review by a member of our team. We will be in touch shortly.</p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">In the meantime, you can start setting up your business profile to showcase the amazing work you do. Be sure to add lots of photos and a thorough description of your services as these will help you win more work from couples.</p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Please feel free to reach out to us if you have any questions.</p>
                    <p style="height: 10px; font-family: \'Ubuntu\', sans-serif;"></p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Laura and Belle xo <br>The wedBooker Co-Founders </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;"></p>
                ',
                'button' => 'Setup My Profile',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Account Approved - Vendor
                'notification_event_id' => 9,
                'email_template_id' => 2,
                // 'frequency' => 'realtime,summary',
                'frequency' => 'realtime',
                'subject' => 'Congrats, your account is now live!',
                'body' => '
                    <h1 style="font-family: \'Ubuntu\', sans-serif;margin: 15px 0;font-size: 36px;font-weight: 300;">You\'re Ready To Start Earning!</h1>

                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;">We are excited to let you know that your business profile has been approved, and is now live on wedBooker.</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;">As a professional community, please ensure that your profile showcases your business as well as possible, with lots of photos and a thorough description of your services.</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;">We look forward to delivering you the wedding work you deserve and helping you to grow your business. Please feel free to reach out to us anytime if you have any questions.</p>
                    <p style="margin: auto auto 20px; font-family: \'Ubuntu\', sans-serif;"></p>
                    <p style="height: 10px; font-family: \'Ubuntu\', sans-serif;"></p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;">
                        Good luck! <br />Laura and Belle xo <br />The wedBooker Co-Founders
                    </p>
                    <p style="height: 10px; font-family: \'Ubuntu\', sans-serif;"></p>
                ',
                'button' => 'Get Started',
                'button_link' => '/dashboard',
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Password Reset
                'notification_event_id' => 4,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Password Reset',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        We heard you need to reset your wedBooker password. No problems at all - let\'s make this quick and easy so you can carry on using your wedBooker account.
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                    PS. If this wasn\'t you, someone may be trying to access your account. Please login and change your password to something secure.
                    </p>
                ',
                'button' => 'Reset My Password',
                'button_link' => null,
                'recipient' => 'admin,parent,vendor,couple',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //New Job Request - Single - Vendor
                'notification_event_id' => 5,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_name] requested a quote from you!',
                'body' => '
                    <h2 style="font-family: \'Ubuntu\', sans-serif; color: #353554;">Job Details</h2>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Couple: </strong>[couple_name]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Looking for: </strong> [category]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Location required: </strong> [location]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Date required: </strong> [date] [flexible_date]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Budget: </strong>[budget]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Event type: </strong> [event]</p>
                ',
                'button' => 'Login To View Full Job',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => '[couple_name],[category],[location],[date],[flexible_date],[budget],[event]',
                'type' => 'email'
            ],
            [ //New Job Request - Multiple - Vendor
                'notification_event_id' => 6,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'High job match!',
                'body' => '
                    <h2 style="font-family: \'Ubuntu\', sans-serif; color: #353554;">Job Details</h2>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Couple: </strong>[couple_name]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Looking for: </strong> [category]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Location required: </strong> [location]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Date required: </strong> [date] [flexible_date]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Budget: </strong>[budget]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Event type: </strong> [event]</p>
                ',
                'button' => 'Login To View Full Job',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => '[couple_name],[category],[location],[date],[flexible_date],[budget],[event]',
                'type' => 'email'
            ],
            [ //New Job Approved - Vendor
                'notification_event_id' => 42,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'A new job matched your business!',
                'body' => '
                    <h2 style="font-family: \'Ubuntu\', sans-serif; color: #353554;">Job Details</h2>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Couple: </strong>[couple_name]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Looking for: </strong> [category]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Location required: </strong> [location]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Date required: </strong> [date] [flexible_date]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Budget: </strong>[budget]</p>
                    <p style="margin: auto auto 10px; font-family: \'Ubuntu\', sans-serif;"><strong>Event type: </strong> [event]</p>
                ',
                'button' => 'Login To View Full Job',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => '[couple_name],[category],[location],[date],[flexible_date],[budget],[event]',
                'type' => 'email'
            ],
            [ //New Job Post - Admin
                'notification_event_id' => 7,
                'email_template_id' => 1,
                'frequency' => 'realtime',
                'subject' => 'New job waiting approval',
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
            [ //New Job Approved - Admin
                'notification_event_id' => 42,
                'email_template_id' => 1,
                'frequency' => 'realtime',
                'subject' => 'Job is now live',
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
            [ //Parent Account Created - Parent
                'notification_event_id' => 22,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Set your [business_name] Password',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your [business_name] wedBooker account has been created. Please click the link below to set your password for this account.
                    </p>
                ',
                'button' => 'Set My Password',
                'button_link' => null,
                'recipient' => 'parent',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //New Job Quote - Couple
                'notification_event_id' => 8,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Quote from [business_name]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have received a quote for your "[category_name]" job for your "[event_name]"
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                // 'button_link' => null,dashboard
                'button_link' => '/dashboard/job-quotes',
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[category_name],[event_name]',
                'type' => 'email'
            ],
            [ //New Message Received - Couple
                'notification_event_id' => 21,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have a new message',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [title],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">You have received a new message from [sender]. Login to your wedBooker account to view this message.</p>
                ',
                'button' => 'View Message Now',
                'button_link' => '/dashboard/messages',
                'recipient' => 'vendor,couple',
                'tokens_subject' => null,
                'tokens_body' => '[title],[sender]',
                'type' => 'email'
            ],
            [ //Contact Form - Admin
                'notification_event_id' => 15,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[reason]',
                'body' => '
                    Name: [name]<br/>
                    Email: [email]<br/>
                    Phone Number: [phone]<br/>
                    How did you hear about us: [source]<br/>
                    Reason For Contacting Us: [reason]<br/>
                    Message: [message]
                ',
                'button' => null,
                'button_link' => '',
                'recipient' => 'admin',
                'tokens_subject' => '[reason]',
                'tokens_body' => '[name],[email],[phone],[source],[reason],[message]',
                'type' => 'email'
            ],
            [ //Delete Account Request - Admin
                'notification_event_id' => 16,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Delete Account Request',
                'body' => '
                    Name: [name]<br/>
                    User Type: [user_type]<br/>
                    Reason: [reason]<br/>
                    Details: [details]<br/>
                ',
                'button' => null,
                'button_link' => '',
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[name],[user_type],[reason],[details]',
                'type' => 'email'
            ],
            [ //Offer Expired - vendor
                'notification_event_id' => 17,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your Exclusive offer on wedBooker requires your attention',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        The exclusive offer that you have been advertising to Couples on your wedBooker profile has now expired. Make sure you remove your offer from your profile page or extend the expiry date to keep your profile up to date.
                    </p>
                ',
                'button' => 'Update Offer',
                'button_link' => '',
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Job Quote Expired - Vendor
                'notification_event_id' => 18,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your quote for [couple_title] has expired',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your quote for [couple_title] has expired. You can extend the quote to give them more time to respond by editing the expiry date in your quote.
                    </p>
                ',
                'button' => 'Extend Quote',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Job Quote Expired - Couple
                'notification_event_id' => 18,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your quote from [business_name] has expired',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your quote from [business_name] has expired. You can request for them to extend the quote to by logging in and sending them a message.
                    </p>
                ',
                'button' => 'Message Business',
                'button_link' => '',
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Job Expired - Couple
                'notification_event_id' => 19,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your job has expired',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        There was no activity on your [category_name] job. If you’d still like to make this booking, you can set your job live again.
                    </p>
                ',
                'button' => 'Set Job live',
                'button_link' => '',
                'recipient' => 'couple',
                'tokens_subject' => null,
                'tokens_body' => '[category_name]',
                'type' => 'email'
            ],
            [ //Booking Confirmed - Vendor
                'notification_event_id' => 10,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have a new confirmed booking!',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [business_name],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have a new confirmed booking! [couple_title] have made payment on your invoice, and the booking is now locked in. Be sure to add this to your calendar and start preparing.
                    </p>
                ',
                'button' => 'View Booking',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => '[business_name],[couple_title]',
                'type' => 'email'
            ],
            [ //Booking Confirmed - Couple
                'notification_event_id' => 10,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your booking with [business_name] is confirmed',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [couple_title],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your payment has been received and your booking is confirmed.
                    </p>
                ',
                'button' => 'View Booking',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Balance Paid - Vendor
                'notification_event_id' => 23,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_title] has paid the final balance',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [business_name],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Make sure you are ready for their booking.
                    </p>
                ',
                'button' => 'View Booking',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Balance Paid - Couple
                'notification_event_id' => 23,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have paid [business_name] in full',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [couple_title],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Make sure you keep in touch with them about any booking details.
                    </p>
                ',
                'button' => 'View Booking',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Booking Cancelled - Vendor
                'notification_event_id' => 24,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your booking with [couple_title] has been cancelled',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your booking with [couple_title] has been cancelled. Please contact us at hello@wedbooker.com if you need any further information.
                    </p>
                ',
                'button' => 'Message Them',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Booking Cancelled - Couple
                'notification_event_id' => 24,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your booking with [business_name] has been cancelled',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your booking with [business_name] has been cancelled. For more information, contact us at hello@wedbooker.com
                    </p>
                ',
                'button' => 'Message Them',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Booking Refunded - Vendor
                'notification_event_id' => 13,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'We have refunded [couple_title] for their cancelled booking',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        We have refunded [couple_title] for their cancelled booking. Please contact us at hello@wedbooker.com if you need any further information.
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Booking Refunded - Couple
                'notification_event_id' => 13,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'We have refunded you for your cancelled booking with [business_name]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        We have refunded you for your cancelled booking with [business_name]. Please contact us at hello@wedbooker.com if you need any further information.
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Booking Date Reminder - Vendor
                'notification_event_id' => 25,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your booking for [couple_title] is coming up',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your booking for [couple_title] is coming up. Make sure you are ready for their event. We recommend reaching out to the couple to touch base.
                    </p>
                ',
                'button' => 'MESSAGE NOW',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Booking Date Reminder - Couple
                'notification_event_id' => 25,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your booking with [business_name] is coming up',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your booking with [business_name] is coming up. If you haven\'t yet, we recommend touching base with them to confirm your booking details.
                    </p>
                ',
                'button' => 'MESSAGE NOW',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Job Post Expiration Reminder - Couple
                'notification_event_id' => 26,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your job is about to expire',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        There has been no recent activity on your [category_name] job. If you would still like to book this, you can always extend your job
                    </p>
                ',
                'button' => 'Extend Job',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => null,
                'tokens_body' => '[category_name]',
                'type' => 'email'
            ],
            [ //Job Quote Expiration Reminder - Couple
                'notification_event_id' => 27,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your quote from [business_name] expires in 3 days',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Still thinking about this quote? Send them a message to request an extension.
                    </p>
                ',
                'button' => 'Message Business',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Job Quote Expiration Reminder - Vendor
                'notification_event_id' => 27,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your quote for [couple_title] expires in 3 days',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Would you like to give them more time? Extend the expiry date in your quote.
                    </p>
                ',
                'button' => 'Extend Expiry Date',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Send Afternoon Account Notification Summary - Vendor, Couple
                'notification_event_id' => 28,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have activity in your wedBooker account',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Login to your wedBooker account to view <a style=\'color:#373654; font-size: 14px;\'>today\'s</a> activity.
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => null,
                'recipient' => 'vendor,couple',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Send Morning Account Notification Summary - Vendor, Couple
                'notification_event_id' => 29,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have activity in your wedBooker account',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Login to your wedBooker account to view <a style=\'color:#373654; font-size: 14px;\'>today\'s</a> activity.
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => null,
                'recipient' => 'vendor,couple',
                'tokens_subject' => null,
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Send Message Inbox Summary - Vendor, Couple
                'notification_event_id' => 30,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have some unread messages',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [title],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">You have some unread messages waiting for you in your wedBooker inbox.</p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard/messages',
                'recipient' => 'vendor,couple',
                'tokens_subject' => null,
                'tokens_body' => '[title]',
                'type' => 'email'
            ],
            [ //Unread Notification - Vendor, Couple
                'notification_event_id' => 31,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You Have Activity Waiting in Your wedBooker Account',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [send_to]
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have activity that is waiting for you in your wedBooker account. Login now to have a look! You are receiving this email because there are notifications awaiting your attention.
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/login',
                'recipient' => 'vendor,couple',
                'tokens_subject' => null,
                'tokens_body' => '[send_to]',
                'type' => 'email'
            ],
            [ //Send Vendor Review To Couples - Couple
                'notification_event_id' => 32,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_title] please leave a review for [vendor_title]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Dear [couple_title],
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Thank you for booking [vendor_title] through wedBooker. We pride ourselves on maintaing a professional community of Wedding Suppliers & Venues, and therefore value the feedback we receive from our Couples.</p>

                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">Please leave a quick review to let us know how you enjoyed working with [vendor_title]. It only takes 2 minutes!</p>
                ',
                'button' => 'Click here to review them now',
                'button_link' => '',
                'recipient' => 'couple',
                'tokens_subject' => '[couple_title],[vendor_title]',
                'tokens_body' => '[couple_title],[vendor_title]',
                'type' => 'email'
            ],
            [ //Payment Reminder - Couple
                'notification_event_id' => 11,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Payment reminder from [business_name]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                    Hi [couple_title], hope the wedding planning is going well. A friendly reminder to pay the amount owing on your invoice as soon as possible. You can click here to view and pay the invoice. Thanks, [business_name]
                    </p>
                ',
                'button' => 'View Invoice & Pay Now',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[couple_title],[business_name]',
                'type' => 'email'
            ],
            [ //Balance Due Reminder - Couple
                'notification_event_id' => 33,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[business_name] has sent you a payment reminder',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have a payment owing to [business_name] for your [category_name] booking.
                    </p>
                ',
                'button' => 'View Invoice & Pay',
                'button_link' => '',
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name],[category_name]',
                'type' => 'email'
            ],
            [ //Invoice Received - Couple
                'notification_event_id' => 34,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Invoice received from [business_name]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You\'ve accepted the quote from [business_name]. Pay the deposit to confirm the booking!
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Invoice Sent - Vendor
                'notification_event_id' => 35,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Invoice sent',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Auto generated invoice was sent to [profile_title]
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => '[profile_title]',
                'type' => 'email'
            ],
            [ //Refund Requested by Couple - Vendor
                'notification_event_id' => 36,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_title] has requested for refund.',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        [couple_title] has request a refund in your event. wedBooker will review this before confirming.
                    </p>
                ',
                'button' => 'Message Now',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Refund Requested by Couple - Couple
                'notification_event_id' => 36,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have requested a refund from [business_name].',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have requested a refund for your event from [business_name]. wedBooker will review this before confirming.
                    </p>
                ',
                'button' => 'Message Now',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Refund Requested by Business - Vendor
                'notification_event_id' => 52,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'You have issued a refund to [couple_title].',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have issued a refund for your event to [couple_title].
                    </p>
                ',
                'button' => 'Message Now',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Refund Requested by Business - Couple
                'notification_event_id' => 52,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[business_name] has issued your refund.',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        [business_name] has issued a refund in your event.
                    </p>
                ',
                'button' => 'Message Now',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Refund Requested by Couple - Admin
                'notification_event_id' => 36,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Couple Requesting for Refund!',
                'body' => '
                    <h1>Refund Request</h1>
                    <h2>Vendor: [business_name]</h2>
                    <h2>Couple: [couple_title]</h2>
                    <p>Amount: $ [amount] </p>
                    <p>Reason: [reason] </p>
                    <p>Cancel Booking: [cancel_booking] </p>
                    <strong>Job Details</strong>
                    <p>Category: [category_name]</p>
                    <p>Locations: [location]</p>

                    <ul class="list-inline">
                        <li>
                            <small><strong>Event Type:</strong></small> <br />
                            [event_name]
                        </li>

                        <li>
                            <small><strong>Date Required:</strong></small> <br />
                            [event_date]
                        </li>

                        <li>
                            <small><strong>Max Budget:</strong></small> <br />
                            [budget]
                        </li>
                    </ul>

                    <h1>Approximate Number of Guests:</h1>
                    [number_of_guests]

                    <h1>Property Types:</h1>
                    <ul>
                        [property_types]
                    </ul>

                    <strong>Looking for...</strong>
                    <p>[looking_for]</p>

                    <h1>Website Requirements:</h1>
                    <ul>
                        [website_requirements]
                    </ul>

                    <h1>Completion Date:</h1>
                    <p>[completion_date]</p>

                    <h1>Other Requirements:</h1>
                    <ul>
                        [other_requirements]
                    </ul>

                    <h1>Time Required:</h1>
                    [time_required]

                    <h1>Venue or Address where Supplier is required:</h1>
                    [venue_or_address]

                    <h1>Shipping Address:</h1>
                    <p>Street: [street]</p>
                    <p>Suburb: [suburb]</p>
                    <p>State: [state]</p>
                    <p>Post Code: [post_code]</p>

                    <h1>Job Specification:</h1>
                    [job_specification]
                ',
                'button' => '',
                'button_link' => '',
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[business_name],[couple_title],[amount],[reason],[cancel_booking],[category_name],[location],[event_name],[event_date],[budget],[number_of_guests],[property_types],[looking_for],[website_requirements],[completion_date],[other_requirements],[time_required],[venue_or_address],[street],[suburb],[state],[post_code],[job_specification]',
                'type' => 'email'
            ],
            [ //Refund Requested by Business - Admin
                'notification_event_id' => 52,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Business Issued a Refund!',
                'body' => '
                    <h1>Refund Issued</h1>
                    <h2>Vendor: [business_name]</h2>
                    <h2>Couple: [couple_title]</h2>
                    <p>Amount: $ [amount] </p>
                    <p>Reason: [reason] </p>
                    <p>Cancel Booking: [cancel_booking] </p>
                    <strong>Job Details</strong>
                    <p>Category: [category_name]</p>
                    <p>Locations: [location]</p>

                    <ul class="list-inline">
                        <li>
                            <small><strong>Event Type:</strong></small> <br />
                            [event_name]
                        </li>

                        <li>
                            <small><strong>Date Required:</strong></small> <br />
                            [event_date]
                        </li>

                        <li>
                            <small><strong>Max Budget:</strong></small> <br />
                            [budget]
                        </li>
                    </ul>

                    <h1>Approximate Number of Guests:</h1>
                    [number_of_guests]

                    <h1>Property Types:</h1>
                    <ul>
                        [property_types]
                    </ul>

                    <strong>Looking for...</strong>
                    <p>[looking_for]</p>

                    <h1>Website Requirements:</h1>
                    <ul>
                        [website_requirements]
                    </ul>

                    <h1>Completion Date:</h1>
                    <p>[completion_date]</p>

                    <h1>Other Requirements:</h1>
                    <ul>
                        [other_requirements]
                    </ul>

                    <h1>Time Required:</h1>
                    [time_required]

                    <h1>Venue or Address where Supplier is required:</h1>
                    [venue_or_address]

                    <h1>Shipping Address:</h1>
                    <p>Street: [street]</p>
                    <p>Suburb: [suburb]</p>
                    <p>State: [state]</p>
                    <p>Post Code: [post_code]</p>

                    <h1>Job Specification:</h1>
                    [job_specification]
                ',
                'button' => '',
                'button_link' => '',
                'recipient' => 'admin',
                'tokens_subject' => null,
                'tokens_body' => '[business_name],[couple_title],[amount],[reason],[cancel_booking],[category_name],[location],[event_name],[event_date],[budget],[number_of_guests],[property_types],[looking_for],[website_requirements],[completion_date],[other_requirements],[time_required],[venue_or_address],[street],[suburb],[state],[post_code],[job_specification]',
                'type' => 'email'
            ],
            [ //Job Quote Extended
                'notification_event_id' => 37,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your quote from [business_name] has been extended',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have more time to consider this quote, review it now.
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Job Quote Response - accepted
                'notification_event_id' => 38,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_title] have accepted your quote',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        The invoice has been sent. Once they pay the deposit, the booking will be confirmed.
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Job Quote Response - request changes
                'notification_event_id' => 39,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_title] has requested to change your quote',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Review their change requests
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Job Quote Response - declined
                'notification_event_id' => 40,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => '[couple_title] has declined your quote',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Your quote for "[couple_title] looking for [category_name]" was declined
                    </p>
                ',
                'button' => 'Login To My wedBooker Account',
                'button_link' => '/dashboard',
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title],[category_name]',
                'type' => 'email'
            ],
            [ //New Job Post - Couple
                'notification_event_id' => 7,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Thanks For Posting Your [category_name] Job',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Thanks For Posting Your [category_name] Job. Click the button below to view your job.
                    </p>
                ',
                'button' => 'View Job',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[category_name]',
                'tokens_body' => '[category_name]',
                'type' => 'email'
            ],
            [ //Job Quote Updated - Couple
                'notification_event_id' => 44,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Updated Quote From [business_name]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have received an updated quote for [couple_title] looking for [category_name]
                    </p>
                ',
                'button' => 'View Quote',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[couple_title],[category_name]',
                'type' => 'email'
            ],
            [ //Job Quote Updated - Vendor
                'notification_event_id' => 44,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Your updated quote has been sent to [couple_title]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                    We\'ll let you know when they respond
                    </p>
                ',
                'button' => 'View My Quote',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => null,
                'type' => 'email'
            ],
            [ //Job Match Reminder - Vendor
                'notification_event_id' => 48,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Reminder: Job From [couple_title]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        [couple_title] is waiting for you to send them a quote.
                    </p>
                ',
                'button' => 'View Job',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Job Quote Reminder - Couple
                'notification_event_id' => 49,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Reminder: Job Quote From [business_name]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        [business_name] is waiting for your response to their quote.
                    </p>
                ',
                'button' => 'View Quote',
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => '[business_name]',
                'tokens_body' => '[business_name]',
                'type' => 'email'
            ],
            [ //Review Received - Vendor
                'notification_event_id' => 20,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'New Review Received From [couple_title]',
                'body' => '
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        [couple_title] has sent your business a review from your past event.
                    </p>
                ',
                'button' => 'View Profile',
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => '[couple_title]',
                'tokens_body' => '[couple_title]',
                'type' => 'email'
            ],
            [ //Payment Made - Couple
                'notification_event_id' => 12,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Payment Receipt',
                'body' => '
                    <h1 style="font-family: \'Ubuntu\', sans-serif;margin: 15px 0;font-size: 36px;font-weight: 300; line-height: normal;">Receipt of Payment</h1>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have made payment to [business_name] for your [category] booking.
                    </p>
                    <table>
                        <tr>
                            <td style="text-align: left; background-color: #e7d8d1; font-size: 14px;">
                                <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                    Total Booking Amount: <strong>$[booking_amount]</strong>
                                </span>
                                <hr style="margin: 0;" />
                                <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                    Amount Paid: <strong>$[amount_paid]</strong>
                                </span>

                                <hr style="margin: 0;" />
                                <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                    Total Still Owing: <strong>$[balance]</strong>
                                </span>
                            </td>
                        </tr>
                    </table>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        <a style="color: #FE5945;" href="[invoice_link]">Download Copy Of Invoice</a>
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        If you have any questions, you can contact us at <a href="mailto:hello@wedbooker.com" style="color: #FE5945;">hello@wedbooker.com</a>
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Kind regards, <br />
                        The wedBooker Team
                    </p>
                ',
                'button' => null,
                'button_link' => null,
                'recipient' => 'couple',
                'tokens_subject' => null,
                'tokens_body' => '[business_name],[category],[booking_amount],[amount_paid],[balance],[invoice_link]',
                'type' => 'email'
            ],
            [ //Payment Made - Vendor
                'notification_event_id' => 12,
                'email_template_id' => 2,
                'frequency' => 'realtime',
                'subject' => 'Remittance Advice',
                'body' => '
                    <h1 style="font-family: \'Ubuntu\', sans-serif;margin: 15px 0;font-size: 36px;font-weight: 300; line-height: normal;">Remittance Advice</h1>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        You have received a payment from [couple_title].
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        <a style="color: #FE5945;" href="[invoice_link]">Download Copy Of Invoice</a>
                    </p>
                    <table>
                        <tr>
                            <td style="text-align: left; background-color: #e7d8d1; font-size: 14px;">
                            <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                Total Booking Amount: <strong>$[booking_amount]</strong>
                            </span>
                            <hr style="margin: 0;" />
                            <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                Payment Received: <strong>$[payment_received]</strong>
                            </span>
                            <hr style="margin: 0;" />
                            <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                WedBooker Fee: <strong>$[wedbooker_fee]</strong>
                            </span>
                            <hr style="margin: 0;" />
                            <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                Amount You Receive: <strong>$[amount_received]</strong>
                            </span>
                            <hr style="margin: 0;" />
                            <span style="padding: 5px; display: block; font-family: \'Ubuntu\'; color: #353554; font-size: 14px;">
                                Still Owing: <strong>$[balance]</strong>
                            </span>
                            </td>
                        </tr>
                    </table>

                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        This will be paid into your nominated bank account. To update your bank details, you can login to <a style="color: #FE5945;" href="https://wedbooker.com">wedBooker.com</a>  and access your business settings, or contact us at <a style="color: #FE5945;" href="mailto:hello@wedbooker.com">hello@wedbooker.com</a>
                    </p>
                    <p style="font-family: \'Ubuntu\', sans-serif;text-decoration: none;color: #353554; font-size: 14px;">
                        Kind regards, <br />
                        The wedBooker Team
                    </p>
                ',
                'button' => null,
                'button_link' => null,
                'recipient' => 'vendor',
                'tokens_subject' => null,
                'tokens_body' => '[couple_title],[payment_received],[booking_amount],[wedbooker_fee],[amount_received],[balance],[invoice_link]',
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

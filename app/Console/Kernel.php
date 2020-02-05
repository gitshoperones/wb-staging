<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\BalanceDueReminder;
use App\Console\Commands\BookingDateReminder;
use App\Console\Commands\CloseExpiredJobPosts;
use App\Console\Commands\CloseExpiredJobQuotes;
use App\Console\Commands\SendMessageInboxSummary;
use App\Console\Commands\JobPostExpirationReminder;
use App\Console\Commands\SendVendorReviewToCouples;
use App\Console\Commands\JobQuoteExpirationReminder;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendMorningAccountNotificationSummary;
use App\Console\Commands\SendAfternoonAccountNotificationSummary;
use App\Console\Commands\UnreadNotificationReminder;
use App\Console\Commands\OfferExpirationReminder;
use App\Console\Commands\JobMatchReminder;
use App\Console\Commands\JobQuoteReminder;
use App\Console\Commands\DraftJobReminder;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BalanceDueReminder::class,// not yet done
        BookingDateReminder::class,
        CloseExpiredJobPosts::class,
        CloseExpiredJobQuotes::class,
        JobPostExpirationReminder::class,
        JobQuoteExpirationReminder::class,
        SendAfternoonAccountNotificationSummary::class,
        SendMessageInboxSummary::class,
        SendMorningAccountNotificationSummary::class,
        SendVendorReviewToCouples::class,
        UnreadNotificationReminder::class,
        OfferExpirationReminder::class,
        JobMatchReminder::class,
        JobQuoteReminder::class,
        DraftJobReminder::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('wedbooker:JobMatchReminder')
            ->dailyAt('0:00')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:JobQuoteReminder')
            ->dailyAt('0:15')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:offerExpirationReminder')
            ->dailyAt('0:30')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:closeExpiredJobPosts')
            ->dailyAt('1:00')->onOneServer()->withoutOverlapping(10);
        
        $schedule->command('wedbooker:bookingDateReminder')
            ->dailyAt('1:30')->onOneServer()->withoutOverlapping(10);
            
        $schedule->command('wedbooker:jobPostExpirationReminder')
            ->dailyAt('2:00')->onOneServer()->withoutOverlapping(10);
            
        $schedule->command('wedbooker:draftJobReminder')
            ->dailyAt('2:10')->onOneServer()->withoutOverlapping(10);

        $schedule->command('backup:run --only-db')->dailyAt('03:00');
        $schedule->command('backup:clean')->dailyAt('03:20');

        $schedule->command('wedbooker:jobQuoteExpirationReminder')
            ->dailyAt('3:30')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:closeExpiredJobQuotes')
            ->dailyAt('4:00')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:balanceDueReminder')
            ->dailyAt('5:00')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:sendMorningAccountNotificationSummary')
            ->dailyAt('06:00')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:sendVendorReviewToCouples')
            ->dailyAt('06:30')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:sendAfternoonAccountNotificationSummary')
            ->dailyAt('16:00')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:sendMessageInboxSummary')
            ->weekly()->mondays()->at('11:00')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:sendMessageInboxSummary')
            ->weekly()->fridays()->at('11:00')->onOneServer()->withoutOverlapping(10);

        $schedule->command('wedbooker:unreadNotificationReminder')
            ->weekly()->mondays()->when(function() { return date('W') % 2; })->at('12:00')->onOneServer()->withoutOverlapping(10);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PageSetting;
use App\Events\NewJobPosted;
use App\Models\Couple;
use Request;
use App\Models\JobPost;
use App\Helpers\NotificationContent;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThanksForPostingYourJob;
use App\Notifications\GenericNotification;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('noneAdmin');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userProfile = '';
    
        $postJob = $this->postGuestJobPost();

        if (isset($postJob)) {
            return redirect(sprintf('/dashboard/job-posts/%s', $postJob['job_post']->id))
                ->with(
                    'modal_message',
                    $postJob['modal_msg']
                );
        }

        if ($user->account === 'parent') {
            $childAccounts = $user->vendorProfile->childVendors()->with([
                'childVendorProfile.user' => function ($q) {
                    $q->whereHas('unreadNotifications')->with([
                        'unreadNotifications' => function ($q) {
                            $q->addSelect(['notifiable_id', 'type']);
                        }
                    ]);
                }
            ])->get();
            return view(sprintf('dashboard.%s', $user->account), compact('childAccounts'));
        }

        if ($user->account === 'vendor') {
            $userProfile = Vendor::where('user_id', $user->id)->with([
                'reviews' => function ($q) {
                    return $q->where('status', 1);
                }
            ])->firstOrfail();
        }

        $notifications = $user->notifications()->where('type', '<>', 'Musonza\\Chat\\Notifications\\MessageSent')
            ->limit(10)->orderBy('created_at', 'DESC')->get();

        $pageSettings = PageSetting::fromPage('Couple Signup')->get();

        return view(sprintf('dashboard.%s.home', $user->account), compact('notifications', 'userProfile', 'pageSettings'));
    }

    public function postGuestJobPost () {
        $user = $this->loggedInUser();
        $jobPost = JobPost::where([
            ['user_id', $user->userA_id],
            ['status', 3],
        ])->orderBy('created_at', 'DESC')->first();
      
        if (isset($user) && $user->onboarding == 1 && $jobPost) {
            $jobPost->status = 5;
            $jobPost->save();
            
            $user_logged = Auth::user();
            $email_notification = (new NotificationContent)->getEmailContent('New Job Post', 'couple');
            Mail::to($user_logged->email)->send(new ThanksForPostingYourJob($user_logged, $email_notification, $jobPost));

            $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Job Post', 'couple');
            foreach ($dashboard_notifications as $dashboard_notification) {
                $dashboard_notification->subject = str_replace('[category_name]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $dashboard_notification->subject);
                $dashboard_notification->body = str_replace('[category_name]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $dashboard_notification->body);
                $dashboard_notification->button_link = sprintf('/dashboard/job-posts/%s', $jobPost->id);

                $user_logged->notify(new GenericNotification([
                    'title' => $dashboard_notification->subject,
                    'body' => $dashboard_notification->body,
                    'btnLink' => $dashboard_notification->button_link,
                    'btnTxt' => $dashboard_notification->button
                ]));
            }

            event(new NewJobPosted($jobPost, $jobPost->vendor_id));

            if (!$jobPost->vendor_id) {
                $modalMsg = 'Your job has been sent to well-matched businesses on wedBooker so they can provide you with a quote.';
            }else {
                $modalMsg = 'Your request has now been sent to the business(es) you specified. We\'ll let you know once they submit their quote to you.';
            }
            
            return [
                'job_post' => $jobPost,
                'modal_msg' => $modalMsg
            ];
       }
    }

    public function loggedInUser() {
        $user = Auth::user();
        $loggedInUserProfile = null;

        if ($user) {
            if ($user->account === 'couple') {
                $loggedInUserProfile = Couple::where('userA_id', $user->id)
                    ->orWhere('userB_id', $user->id)->first();
            } else {
                $loggedInUserProfile = $user->vendorProfile()->with([
                    'locations',
                    'expertise'
                ])->first();
            }
        }

        return $loggedInUserProfile;
   }
}

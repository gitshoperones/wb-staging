<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Media;
use App\Models\Vendor;
use App\Models\JobPost;
use App\Models\SavedJob;
use App\Models\Category;
use App\Events\NewJobPosted;
use Illuminate\Support\Facades\Mail;
use App\Models\FavoriteVendor;
use App\Helpers\MarkNotification;
use App\Repositories\JobPostRepo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\JobPostDeleted;
use App\Http\Requests\StoreJobPostRequest;
use App\Search\JobPost\JobPostSearchManager;
use Illuminate\Support\Facades\Notification;
use App\Helpers\NotificationContent;
use App\Mail\ThanksForPostingYourJob;
use App\Mail\JobPostUpdated;
use App\Notifications\GenericNotification;
use App\Helpers\MultipleEmails;
use App\Models\JobQuote;

class JobPostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['activeAccount']);
        $this->middleware(['doneOnboarding']);
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->account === 'couple') {
            // we will not allow couples to search for jobs.
            abort(404);
        }

        $filters = request()->all() + ['status' => 1];
        $eagerLoads = [
            'userProfile' => function ($q) {
                $q->addSelect(['id', 'userA_id', 'userB_id', 'title', 'profile_avatar']);
            },
            'category' => function ($q) {
                $q->addSelect(['id', 'template', 'name']);
            },
            'event' => function ($q) {
                $q->addSelect(['events.id', 'name']);
            },
            'locations' => function ($q) {
                $q->addSelect(['locations.id', 'state', 'abbr', 'name']);
            },
            'quotes' => function ($q) {
                $q->addSelect(['id', 'job_post_id']);
            },
            'propertyTypes'
        ];

        $jobPosts = JobPostSearchManager::applyFilters($filters, $eagerLoads)->paginate(10);
        $savedJobs = Auth::user()->savedJobs()->pluck('id')->toArray();

        return view('dashboard.vendor.job-posts', compact('jobPosts', 'savedJobs'));
    }

    public function create()
    {
        if (Gate::denies('create-job-post')) {
            abort(403, 'Sorry, only couples can post a job.');
        }
        
        if (request('vendor_id')) {
            FavoriteVendor::updateOrCreate([
                'user_id' => Auth::user()->id,
                'vendor_id' => request('vendor_id')
            ], [
                'user_id' => Auth::user()->id,
                'vendor_id' => request('vendor_id')
            ]);
        }

        return view('job-posts.create');
    }

    public function store(StoreJobPostRequest $request)
    {
        if (Gate::denies('store-job-post')) {
            abort(403);
        }

        $jobPost = (new JobPostRepo)->create($request->all());

        if ($request->status === '0') {
            return redirect('/dashboard/job-posts/draft')
                ->with('modal_message', 'Your job post was saved as draft successfully.');
        }

        $user = Auth::user();
        $email_notification = (new NotificationContent)->getEmailContent('New Job Post', 'couple');
        Mail::to($user->email)->send(new ThanksForPostingYourJob($user, $email_notification, $jobPost));

        $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Job Post', 'couple');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $dashboard_notification->subject = str_replace('[category_name]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $dashboard_notification->subject);
            $dashboard_notification->body = str_replace('[category_name]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $dashboard_notification->body);
            $dashboard_notification->button_link = sprintf('/dashboard/job-posts/%s', $jobPost->id);

            $user->notify(new GenericNotification([
                'title' => $dashboard_notification->subject,
                'body' => $dashboard_notification->body,
                'btnLink' => $dashboard_notification->button_link,
                'btnTxt' => $dashboard_notification->button
            ]));
        }

        event(new NewJobPosted($jobPost, $request->vendor_id));

        if (!$request->vendor_id) {
            $modalMsg = 'Your job has been sent to well-matched businesses on wedBooker so they can provide you with a quote.';
        } else {
            $modalMsg = 'Your request has now been sent to the business(es) you specified. We\'ll let you know once they submit their quote to you.';
        }
        
        return redirect(sprintf('/dashboard/job-posts/%s', $jobPost->id))
            ->with(
                'modal_message',
                $modalMsg
            );
    }

    public function show($jobPostId)
    {
        $jobPost = JobPost::whereId($jobPostId)->with([
            'event',
            'category',
            'locations',
            'propertyTypes',
            'propertyFeatures',
            'timeRequirement',
            'userProfile:id,userA_id,title,profile_avatar',
        ])->first();
        
        $JobQuote = JobQuote::where('user_id', Auth::user()->id)
            ->where('job_post_id', $jobPost->id)
            ->where('status', 3) #Status 3 - Accepted
            ->first();

        if (is_null($JobQuote)) {
            if (
                (!$jobPost) ||
                (Auth::user()->account == 'couple' && $jobPost->user_id !== Auth::id()) ||
                (Auth::user()->account == 'vendor' && $jobPost->status !== 1)
            ) {
                return view('job-posts.not-found');
            }
        }

        if (Auth::user()) {
            $isSaved = SavedJob::where('user_id', Auth::user()->id)
                ->where('job_post_id', $jobPost->id)->exists();
        } else {
            $isSaved = false;
        }

        $gallery = Media::where('commentable_id', $jobPost->id)
            ->where('commentable_type', get_class($jobPost))
            ->where('meta_key', 'jobPostGallery')
            ->get(['id', 'meta_filename']);

        $this->shareEditFlag('editOff');

        $types = [];
        $template = Category::whereId($jobPost->category_id)->firstOrFail()->jobPostTemplates()->first();
        $types['hasTemplate'] = $template ? null : 1 ;
        $types['approx'] = $template ? $template->approxDisplay : null;
        $template = $template ? json_decode($template->fields) : null;

        if(count((array) $template) > 0) {
            foreach ($template as $value) {
                if($value->type == 'time') {
                    $types['time'] = $value->jtext;
                }else if($value->type == 'property') {
                    $types['property'] = $value->jtext;
                }else if($value->type == 'other') {
                    $types['other'] = $value->jtext;
                }else if($value->type == 'website') {
                    $types['website'] = $value->jtext;
                }else if($value->type == 'address') {
                    $types['address'] = $value->jtext;
                }
            }
        }

        return view('job-posts.show', compact('jobPost', 'isSaved', 'gallery', 'types'));
    }

    public function edit($jobPostId)
    {
        $jobPost = JobPost::whereId($jobPostId)->with([
            'locations', 'category', 'propertyTypes', 'event'
        ])->firstOrFail();

        if (Gate::denies('edit-job-post', $jobPost)) {
            abort(403);
        }

        $gallery = Media::where('commentable_id', $jobPost->id)
            ->where('commentable_type', get_class($jobPost))
            ->where('meta_key', 'jobPostGallery')
            ->get(['id', 'meta_filename']);
        
        return view('job-posts.edit', compact('jobPost', 'gallery'));
    }

    public function update(StoreJobPostRequest $request, $jobPostId)
    {
        $jobPost = JobPost::whereId($jobPostId)->firstOrFail();

        if (Gate::denies('edit-job-post', $jobPost)) {
            abort(403);
        }

        $previousStatus = $jobPost->status;

        with(new JobPostRepo)->update($request->all(), $jobPost);

        if ($previousStatus === 0 && (int) $request->status === 5) {
            event(new NewJobPosted($jobPost));
            return redirect(sprintf('/dashboard/job-posts/%s', $jobPost->id))
                ->with(
                    'modal_message',
                    'Your request has now been sent to the business(es) you specified. We\'ll let you know once they submit their quote to you.'
                );
        }

        if((int) $request->status === 1) {
            $users = User::whereHas('notifications', function($q) use($jobPost) {
                    $q->where('type', 'App\Notifications\NewJobPosted')
                        ->where('data', 'LIKE', '%"jobPostId":' . $jobPost->id . '%');
                })
                ->with(['notifications' => function($q) use($jobPost) {
                    $q->where('type', 'App\Notifications\NewJobPosted')
                        ->where('data', 'LIKE', '%"jobPostId":' . $jobPost->id . '%');
                }])
                ->get();

            foreach($users as $user) {
                $email_notification = (new NotificationContent)->getEmailContent('Job Updated', 'vendor');
                $emails = (new MultipleEmails)->getMultipleEmails($user);
                Mail::to($emails)->send(new JobPostUpdated($user, $email_notification, $jobPost));

                $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Updated', 'vendor');
                foreach ($dashboard_notifications as $dashboard_notification) {
                    $dashboard_notification->subject = str_replace('[category]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $dashboard_notification->subject);
                    $dashboard_notification->subject = str_replace('[couple_name]', ucwords(strtolower(isset($jobPost->user->coupleProfile()->title) ? $jobPost->user->coupleProfile()->title : '')), $dashboard_notification->subject);
                    $dashboard_notification->button_link = sprintf('/dashboard/job-posts/%s', $jobPost->id);

                    $user->notify(new GenericNotification([
                        'title' => $dashboard_notification->subject,
                        'body' => $dashboard_notification->body,
                        'btnLink' => $dashboard_notification->button_link,
                        'btnTxt' => $dashboard_notification->button
                    ]));
                }
            }
        }

        if (($previousStatus === 5 && (int) $request->status === 5) || (int) $request->status === 1) {
            return redirect(sprintf('/dashboard/job-posts/%s', $jobPost->id))
                ->with('modal_message', 'Your job post was updated successfully.');
        }

        return redirect('/dashboard/job-posts/draft')
            ->with('modal_message', 'Your job post was updated successfully.');
    }

    public function destroy($id)
    {
        $jobPost = JobPost::whereId($id)->where('user_id', Auth::id())
            ->whereIn('status', [0, 1])
            ->with(['category', 'quotes' => function ($q) {
                $q->addSelect(['id', 'user_id', 'job_post_id']);
            }])->firstOrFail(['id', 'category_id']);

        $vendors = User::whereIn('id', $jobPost->quotes->pluck('user_id'))->get(['id', 'email']);

        if ($vendors) {
            Notification::send($vendors, new JobPostDeleted([
                'title' => sprintf(
                    '%s cancelled their %s job',
                    ucwords(strtolower(Auth::user()->coupleProfile()->title)),
                    $jobPost->category->name
                ),
                'body' => 'They are no longer looking for this service so your quote has been cancelled.',
            ]));
        }

        $jobPost->delete();

        // Delete all notifications related to the job post.
        // DB::table('notifications')->where('data->jobPostId', (int) $id)->delete();

        return redirect()->back()->with('success_message', 'Your job has now been deleted.');
    }

    public function extendExpiration($id)
    {
        $jobPost = JobPost::whereId($id)->where('user_id', Auth::id())->firstOrFail(['id', 'status']);
        $jobPost->update(['status' => 1]);
        $jobPost->touch();

        return redirect()->back()->with(
            'success_message',
            'Your job has been extended for another 60 days so you can still
            receive quotes & book your favourite supplier.'
        );
    }
}

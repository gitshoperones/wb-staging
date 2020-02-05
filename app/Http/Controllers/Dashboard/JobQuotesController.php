<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Fee;
use App\Models\User;
use App\Models\Media;
use App\Models\JobPost;
use App\Models\JobQuote;
use App\Repositories\JobQuoteRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\JobQuoteUpdated;
use App\Notifications\JobQuoteReceived;
use App\Notifications\JobQuoteExtended;
use App\Notifications\GenericNotification;
use App\Http\Requests\StoreJobQuoteRequest;
use App\Repositories\JobQuoteMilestoneRepo;
use App\Http\Requests\UpdateJobQuoteRequest;
use App\Helpers\NotificationContent;
use App\Helpers\MultipleEmails;
use Notification;
use App\Events\NewJobQuote;

class JobQuotesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['activeAccount', 'verifiedBankAccount']);
    }

    public function index()
    {
        abort(404);
    }

    public function create()
    {
        $jobPost = JobPost::whereId(request('job_post_id'))
            ->with([
                'timeRequirement' => function ($q) {
                    $q->addSelect(['job_time_requirements.id', 'name']);
                },
                'category' => function ($q) {
                    $q->addSelect(['id', 'name']);
                },
                'locations' => function ($q) {
                    $q->addSelect(['locations.id', 'name']);
                },
                'event' => function ($q) {
                    $q->addSelect(['id', 'name']);
                },
                'userProfile' => function ($q) {
                    $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                }
            ])->whereStatus(1)->firstOrFail([
                'id', 'user_id', 'event_id', 'specifics', 'budget', 'event_date', 'category_id', 'is_flexible', 'status',
                'number_of_guests', 'required_address', 'job_time_requirement_id'
            ]);

        if ($jobPost->status === 2) {
            abort(403, 'Job is already closed.');
        }

        if (JobQuote::where('user_id', Auth::id())->where('job_post_id', $jobPost->id)->exists()) {
            abort(403, 'You already submitted a quote to this job.');
        }

        if (Gate::denies('create-job-quote')) {
            abort(403);
        }

        $vendorExpertises = Auth::user()->vendorProfile->expertise->pluck('id')->toArray();

        if (!in_array($jobPost->category->id, $vendorExpertises)) {
            abort(403, 'service-does-not-matched');
        }
        
        $profileGallery = Media::where('commentable_id', Auth::user()->vendorProfile->id)
                ->where('commentable_type', 'App\Models\Vendor')
                ->where(function($q) {
                    $q->where('meta_key', 'gallery')
                        ->orWhere('meta_key', 'LIKE', '%featured_%');
                })->get(['id', 'meta_filename']);

        return view('job-quotes.create', compact('jobPost', 'profileGallery'));
    }

    public function store(StoreJobQuoteRequest $request)
    {
        if (Gate::denies('store-job-quote')) {
            abort(403);
        }

        $user = Auth::user();

        JobPost::whereId($request->job_post_id)->whereStatus(1)->firstOrFail(['id']);

        $jobQuote = (new JobQuoteRepo)->create(request()->all());

        with(new JobQuoteMilestoneRepo)->store($jobQuote, $request->milestones);

        if ((int)$request->status === 0) {
            return redirect('/dashboard/draft-quotes')->with('modal_message', 'Your job quote saved as draft successfully.');
        }

        event(new NewJobQuote($jobQuote)); #comment this when you push to GIT the index function.
        
        $this->notifyBankDetails();

        return redirect(sprintf('/dashboard/job-quotes/%s', $jobQuote->id))
            ->with('modal_message', 'Your quote has now been sent to the couple. You can wait to hear back from them now.');
    }

    public function edit($jobQuoteId)
    {
        $jobQuote = JobQuote::whereId($jobQuoteId)->with([
            'additionalFiles',
            'tcFile',
            'milestones' => function ($q) {
                $q->addSelect(['id', 'job_quote_id', 'percent', 'due_date', 'desc']);
            }
        ])->firstOrFail();

        if (Gate::denies('edit-job-quote', $jobQuote)) {
            abort(403);
        }

        $jobPost = JobPost::whereId($jobQuote->job_post_id)
            ->with([
                'timeRequirement' => function ($q) {
                    $q->addSelect(['job_time_requirements.id', 'name']);
                },
                'category' => function ($q) {
                    $q->addSelect(['id', 'name']);
                },
                'locations' => function ($q) {
                    $q->addSelect(['locations.id', 'name']);
                },
                'event' => function ($q) {
                    $q->addSelect(['id', 'name']);
                },
                'userProfile' => function ($q) {
                    $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                }
            ])
            ->firstOrFail([
                'id', 'user_id', 'event_id', 'specifics', 'budget', 'event_date', 'category_id', 'status',
                'number_of_guests', 'required_address', 'job_time_requirement_id'
            ]);

        if ($jobPost->status === 2 && $jobQuote->status === 2) {
            abort(403, 'closed-job');
        }

        if ($jobPost->status === 2) {
            abort(403, 'Sorry this job is already closed.');
        }

        $jobQuoteGallery = Media::where('commentable_id', $jobQuote->id)
            ->where('commentable_type', get_class($jobQuote))
            ->where('meta_key', 'jobQuoteGallery')
            ->get(['id', 'meta_filename']);
        
        $profileGallery = Media::where('commentable_id', Auth::user()->vendorProfile->id)
                ->where('commentable_type', 'App\Models\Vendor')
                ->where(function($q) {
                    $q->where('meta_key', 'gallery')
                        ->orWhere('meta_key', 'LIKE', '%featured_%');
                })->get(['id', 'meta_filename']);

        return view('job-quotes.edit', compact('jobPost', 'jobQuote', 'jobQuoteGallery', 'profileGallery'));
    }

    public function update(UpdateJobQuoteRequest $request, $jobQuoteId)
    {
        $jobQuote = JobQuote::whereId($jobQuoteId)->firstOrFail();
        $jobPost = JobPost::whereId($jobQuote->job_post_id)->with('user')->whereStatus(1)
            ->firstOrFail(['id', 'user_id']);

        if (Gate::denies('update-job-quote', $jobQuote)) {
            abort(403);
        }

        $user = Auth::user();

        $previousQuoteStatus = $jobQuote->status;
        $previousJobExpiration = $jobQuote->duration;
        (new JobQuoteRepo)->update(request()->all(), $jobQuote);

        if ($previousQuoteStatus == 0 && $request->status == 1) {
            $email_notification = (new NotificationContent)->getEmailContent('New Job Quote', 'couple');
            $jobPost->user->notify(new JobQuoteReceived($jobQuote, $jobPost->user, $email_notification));

            $this->notifyBankDetails();

            return redirect(sprintf('/dashboard/job-quotes/%s', $jobQuote->id))->with('modal_message', 'Job Quote sent!');
        }

        if ($previousQuoteStatus == 6 && $request->status == 1) {
            $email_notification = (new NotificationContent)->getEmailContent('New Job Quote', 'couple');
            $jobPost->user->notify(new JobQuoteReceived($jobQuote, $jobPost->user, $email_notification));

            $vendor_email_notification = (new NotificationContent)->getEmailContent('Job Quote Resubmitted', 'vendor');
            $emails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;
            Notification::route('mail', $emails)->notify(new GenericNotification([
                'title' => $vendor_email_notification->subject,
                'body' => $vendor_email_notification->body,
                'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $jobQuote->id)),
                'btnTxt' => $vendor_email_notification->button,
                'jobPostId' => $jobPost->id,
                'notification_type' => $vendor_email_notification->type
            ], $user));

            $vendor_dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Resubmitted', 'vendor');
            foreach($vendor_dashboard_notifications as $dashboard_notification) {
                $user->notify(new GenericNotification([
                    'title' => $dashboard_notification->subject,
                    'body' => $dashboard_notification->body,
                    'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $jobQuote->id)),
                    'btnTxt' => $dashboard_notification->button,
                    'jobPostId' => $jobPost->id,
                    'notification_type' => $dashboard_notification->type
                ], $user));
            }

            return redirect(sprintf('/dashboard/job-quotes/%s', $jobQuote->id))->with('modal_message', 'Job Quote sent!');
        }

        if ($previousQuoteStatus == 1 && $request->status == 1 && $previousJobExpiration < $request->duration) {
            $jobPost->user->notify(new JobQuoteExtended($jobQuote, $jobPost->user));

            return redirect(sprintf('/dashboard/job-quotes/%s', $jobQuote->id))->with('modal_message', 'Job Quote extended!');
        }

        if ($previousQuoteStatus == 2 && $request->status == 1) {
            $email_notification = (new NotificationContent)->getEmailContent('Job Quote Updated', 'couple');
            $jobPost->user->notify(new JobQuoteUpdated($jobQuote, $jobPost->user, $email_notification, 'email'));
            
            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Updated', 'couple');
            foreach($dashboard_notifications as $dashboard_notification) {
                $jobPost->user->notify(new JobQuoteUpdated($jobQuote, $jobPost->user, $dashboard_notification, 'dashboard'));
            }

            $email_notification = (new NotificationContent)->getEmailContent('Job Quote Updated', 'vendor');
            $email_notification->subject = str_replace('[couple_title]', isset($jobPost->userProfile->title) ? $jobPost->userProfile->title : '', $email_notification->subject);
            $emails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;

            Notification::route('mail', $emails)->notify(new GenericNotification([
                'title' => $email_notification->subject,
                'body' => $email_notification->body,
                'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $jobQuote->id)),
                'btnTxt' => $email_notification->button,
                'jobPostId' => $jobPost->id,
                'notification_type' => $email_notification->type
            ], $user));

            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Job Quote Updated', 'vendor');
            foreach($dashboard_notifications as $dashboard_notification) {
                $dashboard_notification->subject = str_replace('[couple_title]', isset($jobPost->userProfile->title) ? $jobPost->userProfile->title : '', $dashboard_notification->subject);

                $user->notify(new GenericNotification([
                    'title' => $dashboard_notification->subject,
                    'body' => $dashboard_notification->body,
                    'btnLink' => url(sprintf('/dashboard/job-quotes/%s', $jobQuote->id)),
                    'btnTxt' => $dashboard_notification->button,
                    'jobPostId' => $jobPost->id,
                    'notification_type' => $dashboard_notification->type
                ], $user));
            }

            return redirect(sprintf('/dashboard/job-quotes/%s', $jobQuote->id))
                ->with('modal_message', 'Your updated quote has been sent!');
        }

        return redirect(sprintf('/dashboard/job-quotes/%s', $jobQuote->id))
            ->with('modal_message', 'Job Quote was updated successfully!');
    }

    public function show($jobQuoteId)
    {
        $jobQuote = JobQuote::whereId($jobQuoteId)->whereHas('jobPost')->with([
            'additionalFiles',
            'invoice',
            'jobPost' => function ($q) {
                $q->addSelect([
                    'id', 'user_id', 'event_id', 'specifics', 'budget', 'event_date',
                    'category_id', 'status', 'number_of_guests', 'job_time_requirement_id',
                    'required_address'
                ])->with([
                    'category' => function ($q) {
                        $q->addSelect(['id', 'name']);
                    },
                    'timeRequirement' => function ($q) {
                        $q->addSelect(['job_time_requirements.id', 'name']);
                    },
                    'locations' => function ($q) {
                        $q->addSelect(['locations.id', 'name']);
                    },
                    'event' => function ($q) {
                        $q->addSelect(['id', 'name']);
                    },
                    'userProfile' => function ($q) {
                        $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                    }
                ]);
            },
            'user' => function ($q) {
                $q->addSelect(['id', 'account'])->with([
                    'vendorProfile' => function ($q) {
                        $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
                    }
                ]);
            },
            'milestones' => function ($q) {
                $q->addSelect(['id', 'percent', 'due_date', 'desc', 'job_quote_id']);
            },
            'tcFile' => function ($q) {
                $q->addSelect(['id', 'meta_filename', 'meta_original_filename']);
            },
            'additionalFiles' => function ($q) {
                $q->addSelect(['files.id', 'meta_filename', 'meta_original_filename']);
            }
        ])->firstOrFail([
            'id', 'user_id', 'job_post_id', 'message', 'specs', 'total', 'duration',
            'tc_file_id', 'confirmed_dates', 'apply_gst', 'locked', 'status', 'amount'
        ]);

        $gallery = Media::where('commentable_id', $jobQuote->jobPost->id)
            ->where('commentable_type', get_class($jobQuote->jobPost))
            ->where('meta_key', 'jobPostGallery')
            ->get(['meta_filename']);

        $jobQuoteGallery = Media::where('commentable_id', $jobQuote->id)
            ->where('commentable_type', get_class($jobQuote))
            ->where('meta_key', 'jobQuoteGallery')
            ->get(['id', 'meta_filename']);

        if (Gate::denies('show-job-quote', $jobQuote)) {
            abort(403);
        }

        return view('job-quotes.show', compact('jobQuote', 'gallery', 'jobQuoteGallery'));
    }

    public function notifyBankDetails()
    {
        $user = Auth::user();
        $paymentSetting = $user->vendorProfile->paymentSetting;

        if ((count($user->jobQuotes) === 1) && (!$paymentSetting || !$paymentSetting->status || $paymentSetting->status === 0)) {
            $email_notification = (new NotificationContent)->getEmailContent('Business First Qoute', 'vendor');
            $emails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;
            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Business First Qoute', 'vendor');

            Notification::route('mail', $emails)->notify(new GenericNotification([
                'title' => $email_notification->subject,
                'body' => $email_notification->body,
                'btnLink' => url($email_notification->button_link),
                'btnTxt' => $email_notification->button,
                'notification_type' => $email_notification->type
            ], $user));

            foreach($dashboard_notifications as $dashboard_notification) {
                $user->notify(new GenericNotification([
                    'title' => $dashboard_notification->subject,
                    'body' => $dashboard_notification->body,
                    'btnLink' => url($dashboard_notification->button_link),
                    'btnTxt' => $dashboard_notification->button,
                    'notification_type' => $dashboard_notification->type
                ], $user));
            }
        }
    }
}

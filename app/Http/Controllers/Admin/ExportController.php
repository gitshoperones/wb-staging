<?php
namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\NewsLetterSubscription;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ContactUsRecord;
use App\Models\RefundRecord;
use App\Models\JobPost;
use App\Search\ConfirmedBooking\ConfirmedBookingSearchManager;
use App\Models\JobQuote;
use Illuminate\Support\Carbon;

class ExportController extends Controller
{
    public function exportUser($accountType = 'vendor')
    {
        if ($accountType === 'vendor') {
            $output = $this->exportVendorUsers();
        } elseif ($accountType === 'couple') {
            $output = $this->exportCoupleUsers();
        } else {
            $output = $this->exportAllUsers();
        }

        return response($output, 200)
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Content-type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=wedbooker-'.$accountType.'-users-'.time().'.csv');
    }

    public function exportVendorUsers()
    {
        $users = User::whereAccount('vendor')
            ->with([
                'vendorProfile' => function ($q) {
                    $q->addSelect(['id', 'user_id', 'business_name'])->with([
                        'expertise', 'locations',
                        'reviews' => function ($q) {
                            $q->whereStatus(1)->selectRaw('vendor_id, count(*) as totalCount, sum(rating) as totalRating');
                        },
                    ]);
                },
                'newsLetter'  => function ($q) {
                    $q->addSelect(['email']);
                },
                'latestNote'  => function ($q) {
                    $q->addSelect(['user_id', 'account_id', 'description']);
                },
            ])->get(['id', 'email', 'fname', 'lname', 'account', 'status']);

        $newLine = "\n";
        $output = 'Vendor Id,Email,FullName,Account,BusinessName,Region,Category,Rating,News Letter, Status,Note' . $newLine;

        foreach ($users as $user) {
            $fname = $user->fname ?: '--';
            $lname = $user->lname ?: '--';
            $fullName = $fname.' '.$lname;
            $businessName = $user->vendorProfile->business_name;
            $region = '"'.$user->vendorProfile->locations->implode('name', ', ').'"';
            $category = '"'.$user->vendorProfile->expertise->implode('name', ', ').'"';
            $note = $user->latestNote ? '"'.$user->latestNote->implode('description', ' ').'"' : '';
            $note = str_replace(['\n', '\r', '\n\r'], ' ', $note);
            $note = preg_replace('#\s+#', ' ', trim($note));
            $newsLetter = $user->newsLetter ? 'Yes' : 'No';

            if ($user->vendorProfile->reviews && isset($user->vendorProfile->reviews[0])) {
                $rating = $user->vendorProfile->reviews[0]['totalRating'] / $user->vendorProfile->reviews[0]['totalCount'];
            } else {
                $rating = 'New to wedbooker';
            }

            $output .= sprintf(
                '%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $user->vendorProfile->id,
                $user->email,
                $fullName,
                $user->account,
                $businessName,
                $region,
                $category,
                $rating,
                $newsLetter,
                $user->status,
                $note,
                $newLine
            );
        }

        return $output;
    }

    public function exportCoupleUsers()
    {
        $users = User::whereAccount('couple')
            ->with([
                'coupleA'  => function ($q) {
                    $q->addSelect(['userA_id', 'title', 'partner_firstname', 'partner_surname']);
                },
                'newsLetter'  => function ($q) {
                    $q->addSelect(['email']);
                },
                'latestNote'  => function ($q) {
                    $q->addSelect(['user_id', 'account_id', 'description']);
                },
            ])->get(['id', 'email', 'fname', 'lname', 'account', 'status']);

        $newLine = "\n";
        $output = 'Email,Full Name,Account,Partner Name,News Letter, Status,Note' . $newLine;

        foreach ($users as $user) {
            $fname = $user->fname ?: '--';
            $lname = $user->lname ?: '--';
            $fullName = $fname.' '.$lname;
            $note = $user->latestNote ? $user->latestNote->implode('description', ' ') : '';
            $note = str_replace(',', '', $note);
            $newsLetter = $user->newsLetter ? 'Yes' : 'No';

            $output .= sprintf(
                '%s,%s,%s,%s,%s,%s,%s,%s',
                $user->email,
                $fullName,
                $user->account,
                optional($user->coupleA)->partner_firstname.' '.$user->partner_surname,
                $newsLetter,
                $user->status,
                $note,
                $newLine
            );
        }

        return $output;
    }

    public function exportAllUsers()
    {
        $users = User::where('account', '!=', "admin")
            ->with([
                'vendorProfile' => function ($q) {
                    $q->addSelect(['id', 'user_id', 'business_name'])->with([
                        'expertise', 'locations'
                    ]);
                },
                'newsLetter'  => function ($q) {
                    $q->addSelect(['email']);
                },
                'latestNote'  => function ($q) {
                    $q->addSelect(['user_id', 'account_id', 'description']);
                },
            ])->get(['id', 'email', 'fname', 'lname', 'account', 'status']);

        $newLine = "\n";
        $output = 'Email,FullName,Account,BusinessName,Region,Category,News Letter, Status,Note' . $newLine;

        foreach ($users as $user) {
            $fname = $user->fname ?: '--';
            $lname = $user->lname ?: '--';
            $fullName = $fname.' '.$lname;
            $businessName = in_array($user->account, ['vendor', 'parent']) && $user->vendorProfile ? $user->vendorProfile->business_name : "--";
            $region = $user->account === 'vendor' ? $user->vendorProfile->locations->implode('name', ' ') : '';
            $category = $user->account === 'vendor' ? $user->vendorProfile->expertise->implode('name', ' ') : '';
            $note = $user->latestNote ? $user->latestNote->implode('description', ' ') : '';
            $note = str_replace(',', '', $note);
            $newsLetter = $user->newsLetter ? 'Yes' : 'No';

            $output .= sprintf(
                '%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $user->email,
                $fullName,
                $user->account,
                $businessName,
                $region,
                $category,
                $newsLetter,
                $user->status,
                $note,
                $newLine
            );
        }

        return $output;
    }

    public function exportContactUsRecords()
    {
        $records = ContactUsRecord::with('subscription')->orderBy('id', 'desc')->get();

        $newLine = "\n";
        $output = 'Name,Email,Phone,"How you heard about us","Reason for contacting",Message,Subsribed' . $newLine;

        foreach ($records as $record) {
            $output .= sprintf(
                '%s,%s,%s,"%s","%s","%s",%s,%s',
                $record->details['name'],
                $record->email,
                $record->details['phone'],
                $record->details['source'],
                $record->details['reason'],
                $record->message,
                ($record->subscription) ? "Yes" : "No",
                $newLine
            );
        }

        return response($output, 200)
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Content-type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=wedbooker-contact-us-records-'.time().'.csv');
    }

    public function exportRefundRequestRecords()
    {
        $records = RefundRecord::with('invoice')->orderBy('id', 'desc')->get();

        $newLine = "\n";
        $output = 'Vendor,Couple,Locations,"Total Payable",Balance,"Refund Amount Asked",Reason,Status' . $newLine;

        foreach ($records as $record) {
            $output .= sprintf(
                '%s,%s,"%s","$ %s","$ %s","$ %s","%s","%s"',
                $record->invoice->jobQuote->user->vendorProfile->business_name,
                $record->invoice->jobQuote->jobPost->userProfile->title,
                $record->invoice->jobQuote->jobPost->locations->implode('name', ',&nbsp;'),
                number_format($record->invoice->total, 2),
                number_format($record->invoice->balance, 2),
                number_format($record->amount, 2),
                $record->reason,
                ucwords($record->statusText()),
                $newLine
            );
        }

        return response($output, 200)
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Content-type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=wedbooker-refund-request-records-'.time().'.csv');
    }

    public function exportJobManagementRecords($type = 'live')
    {
        // TODO: Finish Export on Job Management Records
        if ($type == 'live') {
            $records = JobPost::whereStatus(1)->get();
        } elseif ($type == 'deleted') {
            $records = JobPost::onlyTrashed()->get();
        } elseif ($type == 'expired') {
            $records = JobPost::where('status', '4')->get();
        }

        $newLine = "\n";
        $output = 'Couple,Category,Event,"Locations",Event Date,Created Date,Job Expiry,Status,Total Quotes' . $newLine;

        foreach ($records as $record) {
            $status = 'Closed';

            if ($record->status === 0)
                $status = 'Draft';
            elseif ($record->status === 1 && $record->deleted_at !== null)
                $status = 'Deleted';
            elseif ($record->status === 1)
                $status = 'Live';
            elseif ($record->status === 4)
                $status = 'Expired';

            $output .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s",%s',
                $record->userProfile->title,
                $record->category->name,
                $record->event->name,
                $record->locations->implode('name', ',&nbsp;'),
                $record->event_date ?: 'unknown',
                $record->created_at->format('d/m/Y'),
                $record->updated_at->addWeeks(12)->format('d/m/Y'),
                $status,
                count($record->quotes),
                $newLine
            );
        }

        return response($output, 200)
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Content-type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=wedbooker-export-job-posts-'.$type.'-records-'.time().'.csv');
    }

    public function exportJobQuoteRecords()
    {
        $records = JobQuote::with([
            'user' => function ($q) {
                $q->addSelect(['id'])->with([
                    'vendorProfile' => function ($q) {
                        $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
                    }
                ]);
            },
            'jobPost'
        ])->get([
            'id', 'user_id', 'job_post_id', 'message', 'specs', 'total', 'duration',
            'tc_file_id', 'confirmed_dates', 'apply_gst', 'locked', 'status',
        ]);

        $newLine = "\n";
        $output = '"Business Name",Category,Event,"Locations",Event Date,Quote Amount,Quote Expiry,Status,Couple Name' . $newLine;

        foreach ($records as $record) {

            if ($record->status === 0)
                $status = 'Draft';
            elseif ($record->status === 1)
                $status = 'Pending Response';
            elseif ($record->status === 2)
                $status = 'Request Change';
            elseif ($record->status === 3)
                $status = 'Accepted';
            elseif ($record->status === 4)
                $status = 'Declined';
            elseif ($record->status === 5)
                $status = 'Expired';
            elseif ($record->status === 6)
                $status = 'Witdrawn';

            $output .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s",%s',
                $record->user->vendorProfile->business_name,
                $record->jobPost->category->name,
                $record->jobPost->event->name,
                $record->jobPost->locations->implode('name', ',&nbsp;'),
                $record->jobPost->event_date ?: 'unknown',
                number_format($record->total, 2, ".", ","),
                $record->duration,
                $status,
                $record->jobPost->userProfile->title,
                $newLine
            );
        }

        return response($output, 200)
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Content-type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=wedbooker-export-job-quotes-records-'.time().'.csv');
    }

    public function exportConfirmedBookingsRecords()
    {
        $eagerLoads = [
            'jobQuote' => function ($q) {
                $q->with([
                    'milestones' => function ($q) {
                        $q->where('job_quote_milestones.paid', 0);
                    },
                    'jobPost' => function ($q) {
                        $q->addSelect([
                            'id', 'user_id', 'event_date', 'event_id', 'category_id'
                        ])->with(['locations' => function ($q) {
                            $q->addSelect(['locations.id', 'name']);
                        }, 'event' => function ($q) {
                            $q->addSelect(['events.id', 'name']);
                        }, 'category' => function ($q) {
                            $q->addSelect(['categories.id', 'name']);
                        }, 'userProfile' => function ($q) {
                            $q->addSelect(['id', 'userA_id', 'userB_id', 'title']);
                        }]);
                    },
                    'user' => function ($q) {
                        $q->with(['vendorProfile' => function ($q) {
                            $q->addSelect([
                                'id', 'user_id', 'business_name', 'business_name', 'profile_avatar'
                            ]);
                        }])->addSelect('id');
                    }
                ]);
            },

        ];

        $records = ConfirmedBookingSearchManager::applyFilters([], $eagerLoads)->get();

        $newLine = "\n";
        $output = 'Vendor,Couple,Category,Event,Locations,Total Payable,Balance,Next Payment Due,Event Date,Created Date,Status' . $newLine;

        foreach ($records as $record) {
            $output .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",%s',
                $record->jobQuote->user->vendorProfile->business_name,
                $record->jobQuote->jobPost->userProfile->title,
                $record->jobQuote->jobPost->category->name,
                $record->jobQuote->jobPost->event->name,
                $record->jobQuote->jobPost->locations->implode('name', ',&nbsp;'),
                number_format($record->total, 2, '.', ','),
                number_format($record->balance, 2, '.', ','),
                $record->next_payment_date,
                $record->jobQuote->jobPost->event_date ?: 'unknown',
                $record->created_at->format('d/m/Y'),
                ucwords($record->statusText()),
                $newLine
            );
        }

        return response($output, 200)
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Content-type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=wedbooker-export-confirmed-booking-records-'.time().'.csv');
    }
}

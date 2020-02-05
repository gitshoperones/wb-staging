<?php

namespace App\Repositories;

use Bouncer;
use App\Models\File;
use App\Models\User;
use App\Models\Media;
use App\Models\Vendor;
use App\Models\Invoice;
use App\Models\JobPost;
use App\Models\JobQuote;
use App\Repositories\FileRepo;
use Illuminate\Support\Carbon;
use App\Repositories\MediaRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Notifications\JobQuoteResponse;
use App\Repositories\JobQuoteMilestoneRepo;
use App\Notifications\GenericNotification;
use App\Helpers\MultipleEmails;
use Notification;
use Illuminate\Support\Facades\Storage;

class JobQuoteRepo
{
    private $tax;
    private $amount;

    public function __construct()
    {
        $this->tax = 10;// percent
        $this->amount = 0;
    }

    public function create(array $data)
    {
        $user = Auth::user();

        $this->computeAmount($data['specs']['costs'] ?? []);
        $tax = round($this->computeTotalTax(), 2);
        $data['amount'] = $this->amount;
        $data['total'] = round($this->amount + $tax, 2);
        $data['specs'] = $this->composeSpecs($data['specs']);
        $data['user_id'] = $user->id;
        $data['status'] = (isset($data['status']) && (int) $data['status'] === 0) ? 0 : 1;

        if (!isset($data['duration']) || ! $data['duration']) {
            $data['duration'] = Carbon::now()->addDays(7)->format('d/m/Y');
        }

        $tcFile = $this->uploadTC($data['tac_file'] ?? null);
        $data['tc_file_id'] = $tcFile ? $tcFile->id : null;
        $data['apply_gst'] = $user->vendorProfile->gst_registered;

        $jobQuote = JobQuote::create($data);

        if (isset($data['photos']) && $data['photos']) {
            $this->savePhotos($jobQuote, $data['photos']);
        }

        if (isset($data['files']) && $data['files']) {
            $this->saveFiles($jobQuote, $data['files']);
        }

        if(isset($data['profileGallery']) && $data['profileGallery']) {
            foreach ($data['profileGallery'] as $photo) {
                $media = Media::where('id', $photo)->first();

                $contents = Storage::get($media->meta_filename);
                $filename = "user-uploads/" . time() . "-{$photo}.jpeg";
                
                Storage::put($filename, $contents);

                Media::create([
                    'commentable_id' => $jobQuote->id,
                    'commentable_type' => get_class($jobQuote),
                    'meta_key' => 'jobQuoteGallery',
                    'meta_filename' => $filename
                ]);
            }
        }

        return $jobQuote;
    }

    public function savePhotos(JobQuote $jobQuote, $photos)
    {
        if ($photos && count($photos) > 0) {
            foreach ($photos as $file) {
                $filename = $file->store('user-uploads');
                Media::create([
                    'commentable_id' => $jobQuote->id,
                    'commentable_type' => get_class($jobQuote),
                    'meta_key' => 'jobQuoteGallery',
                    'meta_filename' => $filename
                ]);
            }
        }
    }

    public function saveFiles(JobQuote $jobQuote, $files)
    {
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                if(isset($file)) {
                    $file = (new FileRepo)->store(
                        $jobQuote->user_id,
                        $file,
                        'jobQuoteFiles'
                    );
                    $jobQuote->additionalFiles()->attach($file->id);
                }
            }
        }
    }

    public function update(array $data, JobQuote $jobQuote)
    {
        $this->computeAmount($data['specs']['costs'] ?? []);
        $tax = round($this->computeTotalTax(), 2);
        $data['amount'] = $this->amount;
        $data['total'] = round($this->amount + $tax, 2);
        $data['specs'] = $this->composeSpecs($data['specs']);
        $data['status'] = (isset($data['status']) && (int) $data['status'] === 0) ? 0 : 1;

        if (!isset($data['duration']) || !$data['duration']) {
            $data['duration'] = Carbon::now()->addDays(7)->format('d/m/Y');
        }

        $tcFile = $this->uploadTC($data['tac_file'] ?? null);
        $data['tc_file_id'] = $tcFile ? $tcFile->id : null;

        (new JobQuoteMilestoneRepo)->update($jobQuote, $data['milestones']);

        if (isset($data['photos']) && $data['photos']) {
            $this->savePhotos($jobQuote, $data['photos']);
        }

        if (isset($data['files']) && $data['files']) {
            $this->saveFiles($jobQuote, $data['files']);
        }

        if(isset($data['profileGallery']) && $data['profileGallery']) {
            foreach ($data['profileGallery'] as $photo) {
                $media = Media::where('id', $photo)->first();

                $contents = Storage::get($media->meta_filename);
                $filename = "user-uploads/" . time() . "-{$photo}.jpeg";
                
                Storage::put($filename, $contents);

                Media::create([
                    'commentable_id' => $jobQuote->id,
                    'commentable_type' => get_class($jobQuote),
                    'meta_key' => 'jobQuoteGallery',
                    'meta_filename' => $filename
                ]);
            }
        }

        return $jobQuote->update($data);
    }

    private function composeSpecs(array $specs)
    {
        if (!isset($specs['titles']) || !isset($specs['costs'])) {
            return null;
        }

        $titles = $specs['titles'];
        $costs = $specs['costs'];
        $specs = [];

        foreach ($titles as $key => $title) {
            if ($title || $costs[$key]) {
                $specs[] = [
                    'title' => $title,
                    'cost' => isset($costs[$key]) ? $costs[$key] : null,
                ];
            }
        }

        return $specs;
    }

    private function computeAmount(array $costs)
    {
        $this->amount = collect($costs)->reduce(function ($total, $cost) {
            return $total + $cost;
        });

        return $this;
    }

    private function computeTotalTax()
    {
        if (Auth::user()->vendorProfile->gst_registered === 1) {
            return ($this->tax / 100) * $this->amount;
        }

        return 0;
    }

    public function uploadTC($tcFile)
    {
        if (request('tac_option') === 'new' && $tcFile) {
            return with(new FileRepo)->store(Auth::user()->id, $tcFile, 'tc');
        }

        if (request('tac_option') === 'existing') {
            return File::where('user_id', Auth::user()->id)
                ->where('meta_key', 'tc')->first(['id']);
        }

        return null;
    }

    public function updateStatusByResponse($jobQuote, $response)
    {
        if ($response === 'request changes') {
            $dataUpdates = ['status' => 2];
        }

        if ($response === 'declined') {
            $dataUpdates = ['status' => 4];
        }

        if ($response === 'accepted') {
            $dataUpdates = [
                'status' => 3,
                'locked' => 1,
            ];
            // close the job post
            $this->closeJobPost($jobQuote->job_post_id);

            // create invoice
            $this->createInvoice($jobQuote);
        }

        return $jobQuote->update($dataUpdates);
    }

    public function notifyVendor($jobQuote)
    {
        $jobQuoteOwner = User::whereId($jobQuote->user_id)->firstOrFail(['id', 'account', 'email']);

        Cache::forget(sprintf('cached-messages-count-%s', $jobQuoteOwner->id));

        $emails = ($jobQuoteOwner->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($jobQuoteOwner) : $jobQuoteOwner->email;
        Notification::route('mail', $emails)->notify(new JobQuoteResponse($jobQuote, $jobQuoteOwner, 'email'));
        return $jobQuoteOwner->notify(new JobQuoteResponse($jobQuote, $jobQuoteOwner, 'dashboard'));
    }

    // TODO
    public function notifyCouple($jobQuote) 
    {   
        return $jobQuote->jobPost->user->notify(new GenericNotification(
            [
                'title' => "We are so glad you booked {$jobQuote->user->vendorProfile->business_name}",
                'body' => "Please kindly inform any other businesses if their quote wasn't successful. You can use our simple \"decline\" button to let them know.",
                'btnLink' => url('dashboard/received-quotes'),
                'btnTxt' => 'Let them know'
            ]   
        ));
    }

    public function closeJobPost($jobPostId)
    {
        $jobPost = JobPost::whereId($jobPostId)->firstOrFail();
        $jobPost->status = 2;
        return $jobPost->update();
    }

    public function createInvoice($jobQuote)
    {
        $vendorId = Vendor::where('user_id', $jobQuote->user_id)->firstOrFail(['id'])->id;
        $coupleId = $jobQuote->jobPost->user->coupleProfile()->id;

        return Invoice::firstOrCreate([
            'vendor_id' => $vendorId,
            'couple_id' => $coupleId,
            'job_quote_id' => $jobQuote->id,
            'amount' => $jobQuote->amount,
            'total' => $jobQuote->total,
            'balance' => $jobQuote->total,
            'next_payment_date' => $jobQuote->milestones[0]->due_date,
        ]);
    }
}

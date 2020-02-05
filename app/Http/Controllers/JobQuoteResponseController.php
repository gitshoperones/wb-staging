<?php

namespace App\Http\Controllers;

use Chat;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobQuote;
use App\Events\MessageSent;
use App\Repositories\JobQuoteRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\JobQuoteResponseRequest;
use App\Mail\JobQuoteAccepted;
use Illuminate\Support\Facades\Mail;
use App\Helpers\NotificationContent;

class JobQuoteResponseController extends Controller
{
    public function update(JobQuoteResponseRequest $request, $jobQuoteId)
    {
        $jobQuote = JobQuote::whereId($jobQuoteId)->with(['jobPost' => function ($q) {
            $q->addSelect(['id', 'user_id'])->with('user');
        }])->firstOrFail([
            'id', 'job_post_id', 'user_id', 'amount', 'total', 'status',
        ]);
        
        $notification = (new NotificationContent)->getEmailContent('Job Quote Response - accepted', 'admin');
        Mail::to(config('mail.from.address'))->send(new JobQuoteAccepted($jobQuote, $notification));

        if (Gate::denies('respond-job-quote', $jobQuote)) {
            abort(403);
        }

        if ($request->message) {
            $this->sendMessage($jobQuote, $request->message);
        }

        $jobQuoteRepo = new JobQuoteRepo;
        $jobQuoteRepo->updateStatusByResponse($jobQuote, $request->job_quote_response);
        $jobQuoteRepo->notifyVendor($jobQuote);
        // $jobQuoteRepo->notifyCouple($jobQuote);

        // $notification = (new NotificationContent)->getEmailContent('Job Quote Response - accepted', 'admin');
        // Mail::to(config('mail.from.address'))->send(new JobQuoteAccepted($jobQuote, $notification));

        return redirect()->back()->with('success_message', 'Response sent!');
    }

    public function sendMessage($jobQuote, $msg)
    {
        $conversation = Chat::getConversationBetween(Auth::user()->id, $jobQuote->user_id);

        if (!$conversation) {
            $participants = [Auth::user()->id, $jobQuote->user_id];
            $conversation = Chat::createConversation($participants);
        }

        Chat::conversations($conversation)->for(Auth::user())->readAll();

        $message = Chat::message($msg)
            ->from(Auth::user())
            ->to($conversation)
            ->send();

        return broadcast(new MessageSent($message, $conversation->id))->toOthers();
    }
}

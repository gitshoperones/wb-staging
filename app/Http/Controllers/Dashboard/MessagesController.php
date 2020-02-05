<?php

namespace App\Http\Controllers\Dashboard;

use Chat;
use App\Models\User;
use App\Models\Couple;
use App\Models\Vendor;
use App\Models\JobPost;
use App\Models\JobQuote;
use App\Events\MessageSent;
use App\Mail\NewMessageReceived;
use App\Helpers\MultipleEmails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Helpers\NotificationContent;
class MessagesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $this->clearUsersCachedMessagesCount([$user]);

        $contactList = $this->getContactList();
        $contactHistory = $this->getContactHistory();

        if (request('recipient_user_id')) {
            if (request('recipient_user_id') === $user->id) {
                abort(404);
            }

            $recipientUserId = request('recipient_user_id');
        } else {
            $recipientUserId = isset($contactHistory[0]) && $contactHistory[0]->id !== $user->id ? $contactHistory[0]->id : null;
        }

        $this->shareMostRecentConversation($recipientUserId);

        return view('messages.index', compact(
            'contactHistory',
            'contactList'
        ));
    }

    public function shareMostRecentConversation($recipientUserId)
    {
        $conversation = $recipientAvatar = $title = $recipient = null;
        $messages = [];
        $user = Auth::user();

        if ($recipientUserId) {
            $recipientUser = User::whereId($recipientUserId)->firstOrFail(['id', 'account']);
            $conversation = Chat::getConversationBetween(Auth::user()->id, $recipientUser->id);

            if (!$recipientUser || $recipientUser->id === Auth::id()) {
                abort(404);
            }

            if (!$conversation) {
                $participants = [Auth::user()->id, $recipientUser->id];
                $conversation = Chat::createConversation($participants);
            }

            Chat::conversations($conversation)->for(Auth::user())->readAll();

            $messages = DB::table('mc_messages')
                            ->where('conversation_id', $conversation->id)
                            ->leftJoin('users', 'mc_messages.user_id', '=', 'users.id')
                            ->get()
                            ->toArray();

            if ($recipientUser->account === 'couple') {
                $couple = Couple::where('userA_id', $recipientUser->id)
                    ->orWhere('userB_id', $recipientUser->id)
                    ->firstOrFail(['id', 'title', 'profile_avatar']);

                $recipientAvatar = $couple->profile_avatar;
                $recipient = $couple->title;
                $title = optional($user->vendorProfile)->business_name;
            } else {
                $vendor = $recipientUser->vendorProfile;
                $recipientAvatar = $vendor->profile_avatar;
                $recipient = $vendor->business_name;
                $title = optional($user->coupleA)->title;
            }
        }

        View::share([
            'recipientUserId' => $recipientUserId,
            'recipientAvatar' => $recipientAvatar,
            'conversation' => $conversation,
            'messages' => $messages,
            'title' => $title,
            'recipient' => $recipient
        ]);
    }

    public function getContactHistory()
    {
        $conversationIds = DB::table('mc_conversation_user')->where('user_id', Auth::user()->id)
            ->select('conversation_id')
            ->get()
            ->pluck('conversation_id')
            ->toArray();

        $userConversationIds = DB::table('mc_messages')->whereIn('conversation_id', $conversationIds)
            ->select('conversation_id', DB::raw('max(created_at) as latest_date'))
            ->orderBy('latest_date', 'DESC')
            ->groupBy('conversation_id')
            ->get()
            ->pluck('conversation_id')
            ->toArray();

        $convo_ordered = implode(',', $userConversationIds);

        if($convo_ordered != "") {
            $userIds = DB::table('mc_conversation_user')->where('user_id', '<>', Auth::user()->id)
                ->whereIn('conversation_id', $userConversationIds)
                ->orderByRaw(DB::raw("FIELD(conversation_id, $convo_ordered)"))
                ->get()
                ->pluck('user_id')
                ->toArray();
        }else {
            $userIds = [];
        }

        if (request('recipient_user_id')) {
            if(!in_array((int) request('recipient_user_id'), $userIds))
                array_unshift($userIds, (int) request('recipient_user_id'));
        }

        $ids_ordered = implode(',', $userIds);

        $users = ($ids_ordered != "") 
            ? User::whereIn('id', $userIds)->with([
                'vendorProfile' => function ($q) {
                    $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
                },
                'coupleA' => function ($q) {
                    $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                },
                'coupleB' => function ($q) {
                    $q->addSelect(['id', 'userB_id', 'title', 'profile_avatar']);
                }
            ])
            ->orderByRaw(DB::raw("FIELD(id, $ids_ordered)"))
            ->get(['id'])
            : User::whereIn('id', $userIds)->with([
                'vendorProfile' => function ($q) {
                    $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
                },
                'coupleA' => function ($q) {
                    $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                },
                'coupleB' => function ($q) {
                    $q->addSelect(['id', 'userB_id', 'title', 'profile_avatar']);
                }
            ])
            ->get(['id']);
            
        return $users;
    }

    public function getContactList()
    {
        if (Auth::user()->account === 'couple') {
            $jobPosts = JobPost::where('user_id', Auth::user()->id)
                ->get(['id', 'user_id']);
            $users = JobQuote::whereIn('job_post_id', $jobPosts->pluck('id')->toArray())
                ->get(['id', 'user_id'])->pluck('user_id')->unique()->toArray();
            $contactLists = Vendor::whereIn('user_id', $users)
                ->get(['id', 'user_id', 'business_name', 'profile_avatar']);
        } else {
            $jobQuotes = JobQuote::where('user_id', Auth::user()->id)
                ->get(['id', 'job_post_id']);
            $users = JobPost::whereIn('id', $jobQuotes->pluck('job_post_id')->unique()->toArray())
                ->get(['id', 'user_id'])->pluck('user_id')->unique()->toArray();
            $contactLists = Couple::whereIn('userA_id', $users)
                ->orWhereIn('userB_id', $users)
                ->get(['id', 'userA_id AS user_id', 'title', 'profile_avatar']);
        }

        return $contactLists;
    }

    public function retreiveOrCreateConversation($recipientUserId)
    {
        $recipientUser = User::whereId($recipientUserId)->firstOrFail();
        $conversation = Chat::getConversationBetween(Auth::user()->id, $recipientUser->id);

        if ($conversation) {
            return $conversation;
        }

        $participants = [Auth::user()->id, $recipientUser->id];

        return Chat::createConversation($participants);
    }

    public function store(Request $request)
    {
        $conversation = Chat::conversation($request->conversationId);
        $message = $request->message;

        if ($request->messageType) {
            $message = Storage::url($request->message->store('user-uploads'));
        }

        $message = Chat::message($message)
            ->type($request->messageType ?? 'text')
            ->from(Auth::user())
            ->to($conversation)
            ->send();

        Chat::conversations($conversation)->for(Auth::user())->readAll();

        broadcast(new MessageSent($message->id, $message->conversation_id))->toOthers();
        $this->clearUsersCachedMessagesCount($conversation->users);
        
        foreach ($conversation->users as $receive) {
            if(Auth::user()->id !== $receive['id']) {
                $receiver = User::find($receive['id']);
            }
        }

        if ($receiver->vendorProfile) {
            $title = $receiver->vendorProfile->business_name;
            $sender = Auth::user()->coupleA->title;
            $receiver = (new MultipleEmails)->getMultipleEmails($receiver);
        } else {
            $title = $receiver->coupleA->title;
            $sender = Auth::user()->vendorProfile->business_name;
        }

        $email_notification = (new NotificationContent)->getEmailContent('New Message Received', 'vendor,couple');
        Mail::to($receiver)->send(new NewMessageReceived($title, $sender, $email_notification));

        return response()->json($message);
    }

    public function clearUsersCachedMessagesCount($users)
    {
        foreach ($users as $user) {
            Cache::forget(sprintf('cached-messages-count-%s', $user->id));
        }
    }

    public function deleteConvoMessage(Request $request)
    {
        DB::table('mc_messages')
            ->where('conversation_id', $request->conversationId)
            ->where('id', $request->messageId)->delete();

        $conversationUserIds = DB::table('mc_conversation_user')
            ->where('conversation_id', $request->conversationId)
            ->pluck('user_id');

        $users = User::whereIn('id', $conversationUserIds)->get();
        $conversation = Chat::conversation($request->conversationId);

        foreach ($users as $user) {
            Chat::conversations($conversation)->for($user)->readAll();
        }

        $this->clearUsersCachedMessagesCount($users);

        return response()->json($users);
    }

    public function show($id)
    {
        $message = DB::table('mc_messages')->whereId($id)->first();

        return response()->json($message);
    }

    public function messageNew(Request $request)
    {
        $userId = $request->input('user_id');
        $conversationId = $request->input('conversation_id');
        $user = Auth::user();

        $unread = Auth::user()->notifications
            ->where('type', 'Musonza\Chat\Notifications\MessageSent')
            ->where('data.conversation_id', $conversationId)
            ->where('notifiable_id', $user->id)
            ->where('data.conversation_id', $conversationId)
            ->first()->read_at;

        if (!$unread) {
            if ($conversationId) {
                $last_read = DB::table('mc_messages')
                                ->where('user_id', $userId)
                                ->where('conversation_id', $conversationId)
                                ->orderBy('created_at', 'desc')
                                ->first();
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'unread' => ($unread) ? true : false,
                'last_read' => isset($last_read) ? $last_read : null
            ]
        ]);
    }
}

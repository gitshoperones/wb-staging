<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsLetterSubscription;

class NewsLetterSubscriptionsController extends Controller
{
    public function unsubscribe()
    {
        $email = request()->data['email'];
        
        NewsLetterSubscription::whereEmail($email)->delete();

        return response()->json(['success' => 'Successfully unsubscribed to wedbooker newsletter!'], 200);
    }

    public function subscribe()
    {
        $email = request()->data['email'];

        NewsLetterSubscription::firstOrCreate(['email' => $email]);

        return response()->json(['success' => 'Successfully subscribed to wedbooker newsletter!'], 200);
    }
}

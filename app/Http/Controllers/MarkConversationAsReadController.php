<?php

namespace App\Http\Controllers;

use Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkConversationAsReadController extends Controller
{
    public function update($conversationId)
    {
        $conversation = Chat::conversation($conversationId);
        Chat::conversations($conversation)->for(Auth::user())->readAll();

        return response()->json();
    }
}

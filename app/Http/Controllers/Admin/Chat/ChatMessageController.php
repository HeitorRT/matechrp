<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Events\ChatMessage;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Meeting $meeting, Request $request): \Illuminate\Http\RedirectResponse
    {
        broadcast(new ChatMessage($meeting, $request->get('message')));

        return redirect('/');
    }
}

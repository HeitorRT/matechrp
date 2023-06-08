<?php

namespace App\Http\Controllers\Student\Chat;

use App\Events\ChatMessage;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Inertia\Response;

class ChatMessageController extends Controller
{
    /**
     * @return Response
     */
    public function index(Meeting $meeting): Response
    {
        return inertia('Student/Chat/Index', [
            'meeting' => $meeting
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Meeting $meeting, Request $request): \Illuminate\Http\RedirectResponse
    {
        broadcast(new ChatMessage($meeting, $request->get('message')));

        return redirect('/');
    }
}

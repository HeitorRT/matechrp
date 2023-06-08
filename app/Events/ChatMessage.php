<?php

namespace App\Events;

use App\Models\Meeting;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string|null
     */
    private string|null $message;

    /**
     * @var Meeting
     */
    private Meeting $meeting;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Meeting $meeting, string|null $message)
    {
        $this->message = $message;
        $this->meeting = $meeting;

        session()->push("chat-message.{$this->meeting->id}", [
            'message' => $this->message,
            'user' => auth()->user()->only(['id', 'name']),
        ]);
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'chat-message';
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'messages' => session()->get("chat-message.{$this->meeting->id}", [])
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("chat-message.{$this->meeting->id}");
    }
}

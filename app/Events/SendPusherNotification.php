<?php

namespace App\Events;

use App\Models\ScheduledNotification;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use Pusher\PusherException;

class SendPusherNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private ScheduledNotification $scheduledNotification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ScheduledNotification $scheduledNotification)
    {
        $this->scheduledNotification = $scheduledNotification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return void
     * @throws GuzzleException
     * @throws ApiErrorException
     * @throws PusherException
     */
    public function broadcastOn()
    {
        $options = array(
            'cluster' => 'us2',
            'useTLS' => true
        );
        $pusher = new Pusher(
            'd115b284a9d9df8fddca',
            '3fd1421709bdc5a684cc',
            '1602082',
            $options
        );

        $data['message'] = $this->scheduledNotification->notification->content_pusher;
        $pusher->trigger("pusher-notification-{$this->scheduledNotification->student->id}", "meu-evento-{$this->scheduledNotification->student->id}", $data);

        $this->scheduledNotification->update([
            'send_at_by_pusher' => now()
        ]);
    }
}

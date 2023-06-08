<?php

namespace App\Console\Commands;

use App\Events\SendPusherNotification;
use App\Models\LiveEvent;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class SchedulePusherNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->sendSchedulePusherNotification(
                LiveEvent::whereBetween('start_at', [Carbon::now()->addHour(), Carbon::now()->addHours(2)])->get(),
                Notification::where('identifier', 'Agendamento próximo')->first()
            );

            $this->sendSchedulePusherNotification(
                LiveEvent::whereBetween('start_at', [Carbon::now()->addHour(), Carbon::now()->addHours(2)])->get(),
                Notification::where('identifier', 'Agendamento cancelado')->first()
            );

            $this->sendSchedulePusherNotification(
                LiveEvent::whereBetween('start_at', [Carbon::now()->subHour(), Carbon::now()])->get(),
                Notification::where('identifier', 'Novo agendamento')->first()
            );
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * @param LiveEvent[]|Collection $liveEvents
     * @param Notification $notification
     * @return void
     */
    private function sendSchedulePusherNotification(Collection $liveEvents, Notification $notification): void
    {
        foreach ($liveEvents as $liveEvent) {
            foreach ($liveEvent->students ?? [] as $student) {
                $schedule = $liveEvent->scheduledNotifications()->create([
                    'student_id' => $student->id,
                    'notification_id' => $notification->id,
                ]);

                broadcast(new SendPusherNotification($schedule));
            }
        }
    }
}

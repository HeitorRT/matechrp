<?php

namespace App\Services\Student;

use App\Models\NotificationPreference;
use App\Models\ScheduledNotification;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    /**
     * @return ScheduledNotification[]|Collection
     */
    public function getNotificationsAreNotRead(): Collection
    {
        /** @var Student */

        $user = auth('student')->user();

        return $user->scheduledNotifications()
            ->isNotRead()
            ->orderBy('send_at_by_pusher', 'desc')
            ->get()
            ->filter(function (ScheduledNotification $scheduledNotification, int $key) use ($user) {
                return $user->notificationsPreference()->where([
                    'notification_id' => $scheduledNotification->notification_id,
                    'not_display' => true
                ])->count() === 0;
            });
    }

    /**
     * @param ScheduledNotification $notification
     * @return bool
     */
    public function makeAsRead(ScheduledNotification $notification): bool
    {
        return $notification->update(['read_at_by_system' => now()]);
    }

    /**
     * @return void
     */
    public function makeAllAsRead(): void
    {
        foreach ($this->getNotificationsAreNotRead() as $notification) {
            $this->makeAsRead($notification);
        }
    }

    /**
     * @param ScheduledNotification $notification
     * @return NotificationPreference
     */
    public function notShowNotificationPreference(ScheduledNotification $notification): NotificationPreference
    {
        return NotificationPreference::updateOrCreate([
            'student_id' => $notification->student_id,
            'notification_id' => $notification->notification_id,
        ], [
            'not_display' => true,
        ]);
    }
}

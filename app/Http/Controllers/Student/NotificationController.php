<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ScheduledNotificationResource;
use App\Services\Student\NotificationService;
use App\Models\ScheduledNotification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $notifications = $this->notificationService->getNotificationsAreNotRead();

        return response()->json([
            'notifications' => ScheduledNotificationResource::collection($notifications)
        ]);
    }

    /**
     * @param ScheduledNotification $notification
     * @return JsonResponse
     */
    public function makeNotificationAsRead(ScheduledNotification $notification): JsonResponse
    {
        return response()->json([
            'as_read' => $this->notificationService->makeAsRead($notification)
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function makeAllNotificationAsRead(): JsonResponse
    {
        return response()->json([
            'all_as_read' => $this->notificationService->makeAllAsRead()
        ]);
    }

    /**
     * @param ScheduledNotification $notification
     * @return JsonResponse
     */
    public function notShowMeNotification(ScheduledNotification $notification): JsonResponse
    {
        return response()->json(data: $this->notificationService->notShowNotificationPreference($notification));
    }
}

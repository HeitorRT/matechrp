<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Acess\Authorize;
use App\Helpers\Http\DataQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notification\NotificationIndexRequest;
use App\Http\Requests\Admin\Notification\NotificationUpdateRequest;
use App\Http\Resources\Admin\NotificationResource;
use App\Models\Notification;
use App\Services\Admin\NotificationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

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
     * @return Response
     */
    public function index(NotificationIndexRequest $request): Response
    {
        Authorize::any('notification_index');

        $dataQuery = new DataQuery($request);

        $notifications = $this->notificationService->index(
            $dataQuery->filters(),
            $dataQuery->rowsPerPage(),
            $dataQuery->orderBy('name'),
            $dataQuery->sort()
        );

        return inertia('Admin/Notification/Index', [
            'notifications' => NotificationResource::collection($notifications),
            'query' => $dataQuery->query(),
            'canNotificationEdit' => Authorize::any('notification_update'),
        ]);

        return inertia('Admin/Notification/Index');
    }

    /**
     * @param Notification $notification
     * @return Response
     */
    public function edit(Notification $notification): Response
    {
        Authorize::abortIfNot('notification_update');

        return inertia('Admin/Notification/Edit', [
            'notification' => new NotificationResource($notification),
        ]);
    }

    /**
     * @param Notification $notification
     * @return Response
     */
    public function show(Notification $notification): Response
    {
        return inertia('Admin/Notification/Show', [
            'notification' => new NotificationResource($notification),
        ]);
    }

    /**
     * @param NotificationUpdateRequest $notificationUpdateRequest
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function update(NotificationUpdateRequest $notificationUpdateRequest, Notification $notification): RedirectResponse
    {
        Authorize::abortIfNot('notification_update');

        $this->notificationService->update($notification, $notificationUpdateRequest->validated());

        return redirect()->route('admin.notification.index');
    }
}

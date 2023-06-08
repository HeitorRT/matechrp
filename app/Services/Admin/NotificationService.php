<?php

namespace App\Services\Admin;

use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class NotificationService
{
    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Notification[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        return Notification::when(Arr::get($filters, 'name'), function (Builder $builder, $name) {
            return $builder->where('name', 'like', "%{$name}%");
        })->when($orderBy, function(Builder $query) use ($orderBy, $sort){
            return $query->orderBy($orderBy, $sort);
        })->paginate($rowsPerPage);
    }

    /**
     * @param Notification $notification
     * @param array $requestData
     * @return Notification
     */
    public function update(Notification $notification, array $requestData = []): Notification
    {
        $notification->update($this->transformData($requestData));

        return $notification;
    }

     /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        return [
            'name' => Arr::get($requestData, 'name'),
            'mandatory' => Arr::get($requestData, 'mandatory', true),
            'active' => Arr::get($requestData, 'active', true),
            'send_by_email' => Arr::get($requestData, 'send_by_email'),
            'send_by_whatsapp' => Arr::get($requestData, 'send_by_whatsapp'),
            'send_by_sms' => Arr::get($requestData, 'send_by_sms'),
            'send_by_pusher' => Arr::get($requestData, 'send_by_pusher'),
            'content_pusher' => Arr::get($requestData, 'content_pusher'),
            'content_email' => Arr::get($requestData, 'content_email'),
            'content_sms' => Arr::get($requestData, 'content_sms'),
            'content_whatsapp' => Arr::get($requestData, 'content_whatsapp'),
        ];
    }
}

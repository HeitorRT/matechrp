<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null $id
 * @property Carbon|null $send_at_by_sms
 * @property Carbon|null $send_at_by_whatsapp
 * @property Carbon|null $send_at_by_email
 * @property Carbon|null $send_at_by_pusher
 * @property Carbon|null $read_at_by_system
 * @property Student $student
 * @property int $student_id
 * @property Notification $notification
 * @property int $notification_id
 * @property int $scheduledable_id
 * @property string $scheduledable_type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method Builder isNotRead()
 */
class ScheduledNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'notification_id',
        'send_at_by_sms',
        'send_at_by_whatsapp',
        'send_at_by_email',
        'send_at_by_pusher',
        'read_at_by_system',
        'scheduledable_id',
        'scheduledable_type',
    ];

    protected $casts = [
        'send_at_by_sms' => 'datetime',
        'send_at_by_whatsapp' => 'datetime',
        'send_at_by_email' => 'datetime',
        'send_at_by_pusher' => 'datetime',
        'read_at_by_system' => 'datetime',
    ];

    public function scheduledable()
    {
        return $this->morphTo();
    }

    /**
     * @return HasOne|Student
     */
    public function student(): HasOne|Student
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

     /**
     * @return HasOne|Notification
     */
    public function notification(): HasOne|Notification
    {
        return $this->hasOne(Notification::class, 'id', 'notification_id');
    }

    public function scopeIsNotRead(Builder $builder)
    {
        return $builder->whereNull('read_at_by_system');
    }
}

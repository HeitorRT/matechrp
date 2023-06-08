<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'notification_id',
        'not_display',
    ];

    protected $casts = [
        'not_display' => 'boolean'
    ];

    public function student(): HasOne|Collection
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function notification(): HasOne|Collection
    {
        return $this->hasOne(Notification::class, 'id', 'notification_id');
    }
}

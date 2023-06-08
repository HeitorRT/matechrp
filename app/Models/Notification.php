<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * @property int|null $id
 * @property string $identifier
 * @property string $name
 * @property boolean $mandatory
 * @property boolean $send_by_pusher
 * @property boolean $send_by_email
 * @property boolean $send_by_sms
 * @property boolean $send_by_whatsapp
 * @property string $content_pusher
 * @property string $content_email
 * @property string $content_sms
 * @property string $content_whatsapp
 * @property boolean $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Student|BelongsTo $student
 */
class Notification extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'name',
        'mandatory',
        'send_by_email',
        'send_by_whatsapp',
        'send_by_sms',
        'send_by_pusher',
        'content_pusher',
        'content_email',
        'content_sms',
        'content_whatsapp',
        'active'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mandatory' => 'boolean',
        'send_by_email' => 'boolean',
        'send_by_whatsapp' => 'boolean',
        'send_by_sms' => 'boolean',
        'send_by_pusher' => 'boolean',
        'active' => 'boolean',
    ];
}

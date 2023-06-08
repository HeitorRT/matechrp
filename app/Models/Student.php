<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int|null $id
 * @property string $name
 * @property string $email
 * @property bool $active
 * @property Carbon $inactivated_at
 * @property string $cpf
 * @property string $phone
 * @property string $profile_image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Group[]|Collection $groups
 * @property Meeting[]|Collection $meetings
 * @property ScheduledNotification[]|Collection $scheduledNotifications
 * @property Address $address
 *
 * @property-read array $group_ids
 */
class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'inactivated_at',
        'cpf',
        'phone',
        'profile_image',
        'customer_cpf',
        'customer_phone',
        'customer_address',
        'equal_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'inactivated_at' => 'datetime',
        'equal_data' => 'boolean',
    ];

    /**
     * Attributes
     */
    /**
     * @return array
     */
    public function getGroupIdsAttribute(): array
    {
        return $this->groups->pluck('id')->toArray();
    }

    /**
     * Set the user's active and inactivated_at.
     *
     * @param string  $value
     * @return void
     */
    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = $value;

        if ($this->inactivated_at === null && $value === false) {
            $this->inactivated_at = now();
        } else if($value) {
            $this->inactivated_at = null;
        }
    }

    /**
     * Relationships
     */

     /**
     * @return Group[]|BelongsToMany|Collection
     */
    public function groups(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * @return MorphOne|Address
     */
    public function address(): MorphOne|Address
    {
        return $this->morphOne(Address::class, 'addresseable')->withDefault();
    }

    /**
     * @return Meeting[]|Collection|BelongsToMany
     */
    public function meetings(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Meeting::class);
    }

     /**
     * @return JobVacancy[]|Collection|BelongsToMany
     */
    public function jobVacancies(): BelongsToMany|Collection
    {
        return $this->belongsToMany(JobVacancy::class);
    }

    /**
     * @return Content[]|Collection|BelongsToMany
     */
    public function contentList(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Content::class, 'user_content_lists');
    }

     /**
     * @return ScheduledNotification[]|Collection|HasMany
     */
    public function scheduledNotifications(): HasMany|Collection
    {
        return $this->hasMany(ScheduledNotification::class);
    }

      /**
     * @return ScheduledNotification[]|Collection|HasMany
     */
    public function scheduledNotificationsNotRead(): HasMany|Collection
    {
        return $this->hasMany(ScheduledNotification::class)->isNotRead();
    }

     /**
     * @return NotificationPreference[]|Collection|HasMany
     */
    public function notificationsPreference(): HasMany|Collection
    {
        return $this->hasMany(NotificationPreference::class);
    }

     /**
     * Scopes
     */
    public function scopeCreatedThisMonth(Builder $builder)
    {
        return $builder->whereMonth('created_at', now());
    }

    public function scopeCreatedLastMonth(Builder $builder)
    {
        return $builder->whereMonth('created_at', now()->subMonth());
    }

    public function scopeIsActive(Builder $builder)
    {
        return $builder->where('active', true);
    }

    public function scopeInactivatedThisMonth(Builder $builder)
    {
        return $builder->whereMonth('inactivated_at', now());
    }

    public function scopeInactivatedLastMonth(Builder $builder)
    {
        return $builder->whereMonth('inactivated_at', now()->subMonth());
    }
}

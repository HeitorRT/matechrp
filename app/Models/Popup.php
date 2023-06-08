<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Carbon\Carbon;

/**
 * @property int|null $id
 * @property string $description
 * @property string $image
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property Content[]|Collection $contents
 *
 * @property-read array $contents_ids
 */
class Popup extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'image',
        'start_at',
        'end_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * Attributes
     */
    /**
     * @return array
     */
    public function getContentIdsAttribute(): array
    {
        return $this->contents->pluck('id')->toArray();
    }

     /**
     * Relationships
     */
    /**
     * @return Content[]|Collection|BelongsToMany
     */
    public function contents(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Content::class);
    }


    /**
     * Scopes
     */
    public function scopeFilterLikeDescription(Builder $builder, $description)
    {
        return $builder->when($description, function (Builder $builder, $description) {
            return $builder->where('description', 'like', "%{$description}%");
        });
    }

}

<?php

namespace App\Models;

use App\Enums\ContentAuthorEnum;
use App\Enums\ExtraTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;

/**
 * @property int|null $id
 * @property string $name
 * @property ContentAuthorEnum|string $author
 * @property string $production_type
 * @property string $embed
 * @property string $tags
 * @property boolean $has_seasons
 * @property boolean $highlight
 * @property int $category_id
 * @property int $responsible_id
 * @property int $top_position
 * @property int $access_count
 * @property int $number_of_seasons
 * @property string $image
 * @property string $secondary_image
 * @property string $description_image
 * @property string $screensaver_image
 * @property Carbon $launch_start_at
 * @property Carbon $launch_end_at
 * @property Carbon $end_at
 * @property Student[]|Collection $studentList
 * @property Section[]|Collection $sections
 * @property Section[]|Collection $sectionsOrderedByName
 * @property Season[]|Collection $seasons
 * @property Genre[]|Collection $genres
 * @property Quizz[]|Collection $quizzes
 * @property Chapter $chapter
 * @property User $responsible
 * @property Category $category
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Extra[]|Collection $extras
 * @property Extra[]|Collection $backstage (extras com tipo bastidores)
 * @property Extra[]|Collection $debates (extras com tipo debate)
 * @property Extra[]|Collection $files (extras com tipo arquivo)
 * @property Extra[]|Collection $trailers (extras com tipo trailer)
 *
 * @property-read array $sections_ids
 */
class Content extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'tags',
        'launch_start_at',
        'launch_end_at',
        'author',
        'responsible_id',
        'production_type',
        'end_at',
        'has_seasons',
        'number_of_seasons',
        'highlight',
        'top_position',
        'access_count',
        'image',
        'secondary_image',
        'description_image',
        'screensaver_image',
        'category_id',
        'description',
        'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'launch_start_at' => 'datetime',
        'launch_end_at' => 'datetime',
        'end_at' => 'datetime',
        'has_seasons' => 'boolean',
        'highlight' => 'boolean',
        'active' => 'boolean',
        'author' => ContentAuthorEnum::class,
        'tags' => 'array',
    ];

     /**
     * Relationships
     */
    /**
     * @return Category|BelongsTo
     */
    public function category(): Category|BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    /**
     * @return User|BelongsTo
     */
    public function responsible(): User|BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Francês com a Lígia'
        ]);
    }

    /**
     * @return Genre[]|Collection|BelongsToMany
     */
    public function genres(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * @return Chapter|MorphOne
     */
    public function chapter(): Chapter|MorphOne
    {
        return $this->morphOne(Chapter::class, 'chapterable')->withDefault();
    }

    /**
     * @return Season[]|Collection|HasMany
     */
    public function seasons(): HasMany|Collection
    {
        return $this->hasMany(Season::class)->orderBy('number');
    }

    /**
     * @return Section[]|Collection|BelongsToMany
     */
    public function sections(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Section::class)->withPivot(['sort_number as sort_number'])->orderByPivot('sort_number');
    }

    /**
     * @return Section[]|Collection|BelongsToMany
     */
    public function sectionsOrderedByName(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Section::class)->orderBy('name');
    }

     /**
     * @return Extra[]|Collection|HasMany
     */
    public function extras(): HasMany|Collection
    {
        return $this->hasMany(Extra::class);
    }

    /**
     * @return Extra[]|Collection|HasMany
     */
    public function files(): HasMany|Collection
    {
        return $this->extras()->where('type', ExtraTypeEnum::arquivo());
    }

     /**
     * @return Extra[]|Collection|HasMany
     */
    public function trailers(): HasMany|Collection
    {
        return $this->extras()->where('type', ExtraTypeEnum::trailer());
    }

    /**
     * @return Extra[]|Collection|HasMany
     */
    public function backstage(): HasMany|Collection
    {
        return $this->extras()->where('type', ExtraTypeEnum::bastidor());
    }

     /**
     * @return Extra[]|Collection|HasMany
     */
    public function debates(): HasMany|Collection
    {
        return $this->extras()->where('type', ExtraTypeEnum::debate());
    }

    /**
     * @return Content[]|Collection|BelongsToMany
     */
    public function contentsOfTheSameCollection(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'content_tag', 'content_id', 'content_tag_id')
            ->using(ContentTag::class)
            ->withPivot('type')
            ->withPivotValue('type', 'mesma colecao');
    }

    /**
     * @return Content[]|Collection|BelongsToMany
     */
    public function similarContents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'content_tag', 'content_id', 'content_tag_id')
            ->using(ContentTag::class)
            ->withPivot('type')
            ->withPivotValue('type', 'semelhantes');
    }

    /**
     * @return LiveEvent[]|Collection|HasMany
     */
    public function liveEvents(): HasMany|Collection
    {
        return $this->hasMany(LiveEvent::class);
    }

     /**
     * @return Meeting[]|Collection|HasMany
     */
    public function meetings(): HasMany|Collection
    {
        return $this->hasMany(Meeting::class);
    }

      /**
     * @return Quizz[]|Collection|HasMany
     */
    public function quizzes(): HasMany|Collection
    {
        return $this->hasMany(Quizz::class);
    }

    /**
     * @return Student[]|Collection|BelongsToMany
     */
    public function studentList(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Student::class, 'user_content_lists');
    }

    /**
     * Attributes
     */
    /**
     * @return array
     */
    public function getSectionIdsAttribute(): array
    {
        return $this->sections->pluck('id')->toArray();
    }

    /**
     * @return array
     */
    public function getGenresIdsAttribute(): array
    {
        return $this->genres->pluck('id')->toArray();
    }

    /**
     * Actions
     */
     /**
      * @param integer $topPosition
      * @return boolean
      */
    public function setTopPosition(int $topPosition): bool
    {
        return $this->update([
            'top_position' => $topPosition
        ]);
    }

    /**
     * @return boolean
     */
    public function removeTopPosition(): bool
    {
        return $this->update([
            'top_position' => null
        ]);
    }

    /**
     * Scopes
     */
    public function scopeHasMainImage(Builder $builder)
    {
        return $builder->whereNotNull('image');
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }
}

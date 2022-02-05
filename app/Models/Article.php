<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'articles';
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'source',
        'title',
        'subtitle',
        'slug',
        'format',
        'emoji',
        'published',
        'modified',
        'status',
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->using(ArticleCategory::class)
            ->withPivot('is_primary');
    }

    /**
     * @return HasMany
     */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)
            ->using(ArticleAuthor::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
            ->using(ArticleTag::class);
    }

    /**
     * @return BelongsToMany
     */
    public function socials(): BelongsToMany
    {
        return $this->belongsToMany(Social::class)
            ->using(ArticleSocial::class);
    }

    /**
     * @return HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    public $incrementing = false;
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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->using(ArticleCategory::class)
            ->withPivot('is_primary');
    }

    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)
            ->using(ArticleAuthor::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
            ->using(ArticleTag::class);
    }

    public function socials(): BelongsToMany
    {
        return $this->belongsToMany(Social::class)
            ->using(ArticleSocial::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}

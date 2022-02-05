<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleCategory extends Pivot
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'article_category';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'bool',
    ];
}

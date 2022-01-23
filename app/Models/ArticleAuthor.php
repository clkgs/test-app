<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleAuthor extends Pivot
{
    use HasFactory;

    protected $table = 'article_author';
}

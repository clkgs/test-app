<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleTag extends Pivot
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'article_tag';
}

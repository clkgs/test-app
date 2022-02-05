<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleSocial extends Pivot
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'article_social';
}

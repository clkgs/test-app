<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'contents';
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'type',
        'attributes',
        'content',
    ];
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'attributes' => 'array',
    ];
}

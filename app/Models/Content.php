<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'contents';
    public $incrementing = false;
    protected $fillable = [
        'article_id',
        'type',
        'attributes',
        'content',
    ];
    protected $casts = [
        'attributes' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'medias';
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'source',
        'slug',
        'type',
        'attributes',
        'published',
        'modified',
    ];
    /**
     * @var array<int, string>
     */
    protected $casts = [
        'attributes' => 'array',
    ];
}

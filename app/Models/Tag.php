<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'tags';
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'slug',
    ];
}

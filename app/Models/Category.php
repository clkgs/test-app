<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'categories';
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
}

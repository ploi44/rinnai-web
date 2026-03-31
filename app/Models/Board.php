<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'type',
        'has_thumbnail',
        'has_attachment',
    ];

    public function categories()
    {
        return $this->hasMany(BoardCategory::class)->orderBy('order');
    }
}

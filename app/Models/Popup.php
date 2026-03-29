<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link',
        'target',
        'position_x',
        'position_y',
        'width',
        'height',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
}

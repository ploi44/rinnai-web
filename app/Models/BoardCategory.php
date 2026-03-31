<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardCategory extends Model
{
    protected $fillable = ['board_id', 'name', 'order'];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}

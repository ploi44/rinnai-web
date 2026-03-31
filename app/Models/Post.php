<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id',
        'user_id',
        'title',
        'content',
        'thumbnail',
        'category_id',
        'attachments',
        'created_at',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function category()
    {
        return $this->belongsTo(BoardCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

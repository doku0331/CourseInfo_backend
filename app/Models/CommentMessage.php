<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'comment_id',
    ];
    public function comment()
    {
        return $this->belongsTo('App\Models\Comment', 'comment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

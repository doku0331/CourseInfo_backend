<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentMessage extends Model
{
    use HasFactory;

//TODO: 加入fillable的屬性

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment', 'comment_id', 'id');
    }
}

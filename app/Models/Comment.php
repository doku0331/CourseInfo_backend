<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    //TODO: 加入fillable的屬性

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id', 'id');
    }
    public function messages()
    {
        return $this->hasMany('App\Models\CommentMessage', 'comment_id', 'id');
    }
}

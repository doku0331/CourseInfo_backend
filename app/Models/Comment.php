<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'teaching',
        'grading',
        'assignment',
        'comment',
        'isPublish',
        'course_id',
    ];

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

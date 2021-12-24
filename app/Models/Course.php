<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

//TODO: 加入fillable的屬性

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'course_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Modles\User', 'course_user_likes')
            ->withTimestamps();
    }
}

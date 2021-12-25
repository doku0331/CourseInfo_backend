<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

//TODO: 加入fillable的屬性

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'course_id', 'id');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Models\User', 'course_user_likes')
            ->withTimestamps();
    }
}

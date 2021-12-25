<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function userLike()
    {
        $userId = Auth::user()->id;
        $result = DB::table('course_user_likes')
            ->join('courses', 'course_user_likes.course_id', '=', 'courses.id')
            ->where('user_id', $userId)
            ->select(
                'course_id',
                "course_name",
                "teacher",
                "semester",
                "department",
                "credit"
            )
            ->get();

        return response(['data' => $result], 200);
    }
}

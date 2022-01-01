<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show', 'CommentMessage']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //找出所有comment沒必要
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //policy的設定
        $this->authorize('create', Comment::class);

        //驗證
        $this->validate($request, [
            'rating' => 'required|integer|max:5',
            'teaching' => 'nullable',
            'grading' => 'nullable',
            'assignment' => 'nullable',
            'comment' => 'nullable',
            'course_id' => 'nullable|exists:courses,id',
        ]);
        //綁定關係
        //前端要把course_id一起傳送
        try {
            DB::beginTransaction();
            //建立關係 新增評論
            $comment = Auth()->user()->comments()->create($request->all());
            //讀取完整資料欄位
            $comment = $comment->refresh();
            //寫入第二張表
            $course = Course::find($comment->course_id);
            $like = DB::table('course_user_likes')
                ->where('course_id', $comment->course_id)
                ->where('user_id', Auth()->user()->id)
                ->first();
            if (!isset($like)) {
                $course->likes()->attach(auth()->user()->id);
            }
            DB::commit();
            return response($comment, 201);

        } catch (\Exception$e) {
            DB::rollBack();
            return response(
                ['message' => '異常'], 500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return response($comment, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $this->validate($request, [
            'rating' => 'required|integer|max:5',
            'teaching' => 'nullable',
            'grading' => 'nullable',
            'assignment' => 'nullable',
            'comment' => 'nullable',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        // $this->validate()
        $comment->update($request->all());
        return response($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response(['message' => "刪除成功"], 200);
    }

    public function CommentMessage(Comment $comment, Request $request)
    {
        $commentContent = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.id', $comment->id)
            ->select(
                'comments.id',
                "rating",
                'teaching',
                "grading",
                "assignment",
                "comment",
                "users.name as author"
            )
            ->first();

        $messages = DB::table('comment_messages')
            ->join('users', 'comment_messages.user_id', '=', 'users.id')
            ->where('comment_id', $comment->id)
            ->select(
                'users.id as authorId',
                'comment_messages.id',
                "message",
                "comment_messages.created_at",
                "users.name as author"
            )->get();

        $result = compact('commentContent', 'messages');

        return response($result, 200);
    }
}

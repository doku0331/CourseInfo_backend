<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show']]);
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
        $this->authorize('create', Comment::class);

        $this->validate($request, [
            'rating' => 'required|integer|max:5',
            'teaching' => 'nullable',
            'grading' => 'nullable',
            'assignment' => 'nullable',
            'comment' => 'nullable',
            'course_id' => 'nullable|exists:courses,id',
        ]);
        //前端要把course_id一起傳送
        $comment = Auth()->user()->comments()->create($request->all());
        $comment = $comment->refresh();
        return response($comment, 201);
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
        $this->validate($request, [
            'rating' => 'required|integer|max:5',
            'teaching' => 'nullable',
            'grading' => 'nullable',
            'assignment' => 'nullable',
            'comment' => 'nullable',
            'course_id' => 'nullable|exists:courses,id',
        ]);
        $this->authorize('update', $comment);

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
}

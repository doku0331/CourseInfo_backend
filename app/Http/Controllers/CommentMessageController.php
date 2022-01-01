<?php

namespace App\Http\Controllers;

use App\Models\CommentMessage;
use Illuminate\Http\Request;

class CommentMessageController extends Controller
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
    public function index()
    {
        //找出所有message沒必要
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('create', CommentMessage::class);

        $this->validate($request, [
            'message' => 'nullable',
            'comment_id' => 'nullable|exists:comments,id',
        ]);
        //前端要把course_id一起傳送
        $comment = Auth()->user()->messages()->create($request->all());
        $comment = $comment->refresh();
        return response($comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommentMessage  $message
     * @return \Illuminate\Http\Response
     */
    public function show(CommentMessage $message)
    {

        return response($message, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommentMessage  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommentMessage $message)
    {
        $this->authorize('update', $message);

        $this->validate($request, [
            'message' => 'nullable',
            'comment_id' => 'nullable|exists:courses,id',
        ]);

        $message->update($request->all());
        return response($message, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommentMessage  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentMessage $message)
    {
        $this->authorize('delete', $message);
        $message->delete();
        return response(['message' => "刪除成功"], 200);

    }
}

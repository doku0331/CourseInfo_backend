<?php

namespace App\Http\Controllers;

use App\Models\CommentMessage;
use Illuminate\Http\Request;

class CommentMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommentMessage  $CommentMessage
     * @return \Illuminate\Http\Response
     */
    public function show(CommentMessage $CommentMessage)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommentMessage  $CommentMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommentMessage $CommentMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommentMessage  $CommentMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentMessage $CommentMessage)
    {
        //
    }
}

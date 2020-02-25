<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $comment = Comment::create([
            "body"=>$request->body,
            "user_id"=>$request->user_id,
            "commentable_id"=>$request->commentable_id,
            "commentable_type"=>$request->commentable_type
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        return view('comments.comment')->with('comment', $comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('comments.comment_form')->with('comment', $comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->update([
            "body"=>$request->body,
            "user_id"=>$request->user_id,
            "commentable_id"=>$request->commentable_id,
            "commentable_type"=>$request->commentable_type
        ]);
        return redirect($request->back);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $commentable_id = $comment->commentable_id;
        $commentable_type = $comment->commentable_type;
        foreach ($comment->comments as $com) {
            $com->delete();
        }
        $comment->delete();
        return $this->goTo($commentable_id, $commentable_type);
    }

    public function goTo($commentable_id, $commentable_type){
        switch($commentable_type){
            case 'App\Comment':
                return redirect()->back();
                break;
            case 'App\User':
                return redirect()->action('UsersController@show', ['user'=>$commentable_id]);
                break;
            case 'App\Video':
                return redirect()->action('VideosController@show', ['video'=>$commentable_id]);
                break;
        }
    }


}

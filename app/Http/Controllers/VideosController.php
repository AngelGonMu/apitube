<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Video;

class VideosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a filtered/not filtered list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $o = $request->o;
        switch($o){
            case 2: 
                $field = "created_at";
                $order = "asc";
                break;
            case 3: 
                $field = "title";
                $order = "asc";
                break;
            case 4: 
                $field = "title";
                $order = "desc";
                break;
            default:
                $o = 1;
                $field = "created_at";
                $order = "desc";
                break;
        }

        if($request->has('s')){
            $videos = Video::where('title', 'like', '%'.$request->s.'%')
                        ->orWhere('description', 'like', '%'.$request->s.'%')
                        ->orderBy($field, $order)
                        ->paginate(6)
                        ->appends('s',$request->s)
                        ->appends('o',$o);
        } else {
            $videos = Video::orderBy($field, $order)
                        ->paginate(6)
                        ->appends('o',$o);
        }
        return view('videos.videos', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.video_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('video')){
            $ext = $request->file('video')->extension();
            if($ext==="mp4"){
                $video = Video::create([
                            'title'=>$request->title, 
                            'description'=>$request->description, 
                            'status'=>$request->status, 
                            'user_id'=>$request->user_id,
                            'video_path'=>$request->file('video')->store('videos')
                        ]);
            } else {
                return view('video_form')->with(["error"=>"Tipo de fichero no valido"]);
            }
        }
        //$request->file('avatar')->store('avatars');
        return redirect()->action('VideosController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::find($id);
        return view('videos.video')->with('video', $video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = Video::find($id);
        return view('videos.video_form')->with('video', $video);
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
        $video = Video::find($id);
        if($request->hasFile('video')){
            $ext = $request->file('video')->extension();
            if($ext==="mp4"){
                Storage::delete($video->video_path);
                $video->update([
                            'title'=>$request->title, 
                            'description'=>$request->description, 
                            'status'=>$request->status, 
                            'user_id'=>$request->user_id,
                            'video_path'=>$request->file('video')->store('videos')
                        ]);
            } else {
                return view('video_form')->with(["error"=>"Tipo de fichero no valido"]);
            }
        }
        return redirect()->action('VideosController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::find($id);
        Storage::delete($video->video_path);
        $video->delete();
        return redirect()->action('VideosController@index');
    }
}

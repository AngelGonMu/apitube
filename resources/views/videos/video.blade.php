@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>{{$video->title}}</h3>
            <video class="embed-responsive" src="{{asset("storage/$video->video_path")}}" controls></video>
            <h5 class="mt-2">Description</h5>
            <p>{{ $video->description }}</p>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Comments ({{$video->comments->count()}})</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/comments') }}" class="mt-2">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="body" class="form-control" name="body" rows="4" placeholder="Add your comment here..."></textarea>
                            </div>

                            <div class="col-md-12 mt-2">
                                <input id="user_id" name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                                <input id="commentable_type" name="commentable_type" type="hidden" value="App\Video">
                                <input id="commentable_id" name="commentable_id" type="hidden" value="{{ $video->id }}">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Publish
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2"></div>
                    @foreach ($video->comments as $comment)
                        <div class="col-12 my-2">
                            <div class="card">
                                <div class="card-body">
                                    <p>{{$comment->user->name}} 
                                        <small class="font-italic">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}
                                            <span>
                                                @if($comment->updated_at>$comment->created_at)
                                                 (Edited {{ Carbon\Carbon::parse($comment->updated_at)->diffForHumans()}})
                                                @endif
                                            </span>
                                        </small>
                                    </p>
                                    <h5 class="card-title">{{$comment->body}}</h5>
                                    @if($video->user_id===Auth::user()->id||$comment->user_id===Auth::user()->id)
                                    <form method="POST" action="{{ url('/comments/'.$comment->id) }}">
                                        @csrf
                                        @if(isset($comment))
                                            @method('delete')
                                        @endif
                                        <div class="form-group row">
                                            <div class="col-md-12 mt-2">
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#commentModal" data-reply-to="{{$comment->id}}" data-reply-id="{{$comment->commentable_id}}" onclick="showCommentModal(this)">Reply</button>
                                                @if($comment->user_id===Auth::user()->id)
                                                <a href="{{url('/comments/'.$comment->id.'/edit')}}" class="btn btn-warning">Edit</a>
                                                @endif
                                                <button type="submit" class="btn btn-danger">
                                                    Delete
                                                </button>
                                                @if($comment->comments->count()>0)
                                                <a href="{{url('/comments/'.$comment->id)}}" class="btn btn-secondary">Replies ({{$comment->comments->count()}})</a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/comments') }}" class="mt-2">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea id="body" class="form-control" name="body" rows="4" placeholder="Add your comment here..."></textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <input id="reply_user_id" name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                            <input id="reply_commentable_type" name="commentable_type" type="hidden" value="App\Comment">
                            <input id="reply_commentable_id" name="commentable_id" type="hidden">
                            <button type="submit" class="btn btn-primary btn-block">
                                Publish
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

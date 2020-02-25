@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if($comment->commentable_type==="App\Video")
            <a class="btn btn-success" href="{{ url('videos/'.$comment->commentable_id) }}">Go back</a>
            @endif
            @if($comment->commentable_type==="App\User")
            <a class="btn btn-success" href="{{ url('users/'.$comment->commentable_id) }}">Go back</a>
            @endif
        </div>
        <div class="col-12 my-2">
            <div class="card bg-info">
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
                    @if($comment->user_id===Auth::user()->id)
                    <form method="POST" action="{{ url('/comments/'.$comment->id) }}">
                        @csrf
                        @if(isset($comment))
                            @method('delete')
                        @endif
                        <div class="form-group row">
                            <div class="col-md-12 mt-2">
                                @if($comment->user_id===Auth::user()->id)
                                <a href="{{url('/comments/'.$comment->id.'/edit')}}" class="btn btn-warning">Edit</a>
                                @endif
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @foreach ($comment->comments as $com)
            <div class="col-12 my-2 ml-4">
                <div class="card">
                    <div class="card-body">
                        <p>{{$com->user->name}} 
                            <small class="font-italic">{{ Carbon\Carbon::parse($com->created_at)->diffForHumans()}}
                                <span>
                                    @if($com->updated_at>$com->created_at)
                                        (Edited {{ Carbon\Carbon::parse($com->updated_at)->diffForHumans()}})
                                    @endif
                                </span>
                            </small>
                        </p>
                        <h5 class="card-title">{{$com->body}}</h5>
                        @if($com->user_id===Auth::user()->id)
                        <form method="POST" action="{{ url('/comments/'.$com->id) }}">
                            @csrf
                            @if(isset($com))
                                @method('delete')
                            @endif
                            <div class="form-group row">
                                <div class="col-md-12 mt-2">
                                    @if($com->user_id===Auth::user()->id)
                                    <a href="{{url('/comments/'.$com->id.'/edit')}}" class="btn btn-warning">Edit</a>
                                    @endif
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
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
@endsection

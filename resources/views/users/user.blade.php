@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>{{$user->name}}'s profile</h3>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">Videos ({{$user->videos->count()}})</div>

                <div class="card-body">
                    <div class="row mt-2">
                    @foreach ($user->videos as $video)
                        <div class="col-sm-6 col-md-4 my-2">
                            <div class="card">
                                <div class="card-body">
                                    <video class="embed-responsive" src="{{asset("storage/$video->video_path")}}"></video>
                                    <p class="text-right font-italic"><small>{{ Carbon\Carbon::parse($video->created_at)->diffForHumans()}}</small></p>
                                    <h5 class="card-title">{{$video->title}}</h5>
                                    <p class="card-text" style="min-height: 50px;">{{ str_limit($video->description, $limit = 80, $end = ' ...') }}</p>
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <a href="{{url('/videos/'.$video->id.'')}}" class="btn btn-info">View</a>
                                        @if($video->user_id===Auth::user()->id)
                                        <a href="{{url('/videos/'.$video->id.'/edit')}}" class="btn btn-warning">Edit</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">Comments ({{$user->comments->count()}})</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/comments') }}" class="mt-2">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="body" class="form-control" name="body" rows="4" placeholder="Add your comment here..."></textarea>
                            </div>

                            <div class="col-md-12 mt-2">
                                <input id="user_id" name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                                <input id="commentable_type" name="commentable_type" type="hidden" value="App\User">
                                <input id="commentable_id" name="commentable_id" type="hidden" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Publish
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2">
                    @foreach ($user->comments as $com)
                    <div class="col-12 my-2">
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
            </div>
        </div>
    </div>
</div>
@endsection

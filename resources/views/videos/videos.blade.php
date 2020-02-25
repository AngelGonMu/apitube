@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <p class="h1">Videos <a href="{{ url('videos/create') }}" class="btn btn-primary">New</a></p>
    </div>
    <div class="row mt-2">
            @if(is_null($videos))
            <p>No videos found</p>
            @else
                <div class="col-12">
                    <form method="GET" action="{{ url('/videos') }}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="orderSelect" class="form-control" name="o">
                                        <option value="1" {{app('request')->input('o') == 1 ? 'selected':''}}>Newest</option>
                                        <option value="2" {{app('request')->input('o') == 2 ? 'selected':''}}>Oldest</option>
                                        <option value="3" {{app('request')->input('o') == 3 ? 'selected':''}}>A-Z</option>
                                        <option value="4" {{app('request')->input('o') == 4 ? 'selected':''}}>Z-A</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input class="form-control mr-sm-2" id="s" name="s" type="text" placeholder="Search" value="{{app('request')->input('s')}}">
                                </div>
                            </div>
                            <div class="col-12">
                            <button type="submit" class="btn btn-success btn-block btn-sm">
                                Filter
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
                @foreach ($videos as $video)
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
                <div class="col-12">
                {{ $videos->links() }}
                </div>
            @endif
    </div>
</div>
@endsection

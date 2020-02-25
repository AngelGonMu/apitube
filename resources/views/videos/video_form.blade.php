@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(!isset($video)) Crear @else Editar @endif Video
                </div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ isset($video) ? url('/videos/'.$video->id) : url('/videos') }}">
                        @csrf
                        @if(isset($video))
                            @method('put')
                        @endif
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" required autocomplete="title" value="{{isset($video) ? $video->title : ''}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" rows="3">@if(isset($video)){{$video->description}}@endif</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">
                                <select id="status" class="form-control" name="status" required>
                                    <option {{ ( isset($video) && $video->status==='Public' ) ? 'selected' : '' }}>Public</option>
                                    <option {{ ( isset($video) && $video->status==='Private' ) ? 'selected' : '' }}>Private</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="video" class="col-md-4 col-form-label text-md-right">Video</label>
                            <div class="col-md-6">
                                <input id="video" type="file" class="form-control-file" name="video" accept=".mp4" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input id="user_id" name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{url('/videos')}}" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                    @if(isset($video)&&$video->user_id===Auth::user()->id)
                    <form method="POST" action="{{ url('/videos/'.$video->id) }}" class="form-inline">
                        @csrf
                        @if(isset($video))
                            @method('delete')
                        @endif
                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

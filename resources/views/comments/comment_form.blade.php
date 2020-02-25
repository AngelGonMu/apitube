@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@if(!isset($comment))
                        Crear
                    @else
                        Editar
                    @endif Comentario
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ isset($comment) ? url('/comments/'.$comment->id) : url('/comments') }}">
                        @csrf
                        @if(isset($comment))
                            @method('put')
                        @endif
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="body" class="form-control" name="body" rows="4" placeholder="Add your comment here...">{{isset($comment) ? $comment->body : ''}}</textarea>
                            </div>

                            <div class="col-md-12 mt-2">
                                <input id="user_id" name="user_id" type="hidden" value="{{ $comment->user_id }}">
                                <input id="commentable_id" name="commentable_id" type="hidden" value="{{ $comment->commentable_id }}">
                                <input id="commentable_type" name="commentable_type" type="hidden" value="{{ $comment->commentable_type }}">
                                <input id="back" name="back" type="hidden" value="{{ url()->previous() }}">
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
</div>
@endsection

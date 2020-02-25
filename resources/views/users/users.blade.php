@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <p class="h1">Usuarios</p>
    </div>
    <div class="row mt-2">
            @if(is_null($users))
            <p>No existen usuarios</p>
            @else
            <div class="col-12 mt-2">
            {{ $users->links() }}
            </div>
            <div class="list-group col-12">
                @foreach ($users as $user)
                    <div class="list-group-item list-group-item-action">
                        <a href="{{url('/user/'.$user->id)}}">{{$user->name}}</a>
                    </div>
                @endforeach
            </div>
            @endif
    </div>
</div>
@endsection

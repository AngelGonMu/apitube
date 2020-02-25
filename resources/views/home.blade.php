@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    Welcome {{Auth::user()->name}}!

                    <div class="list-group mt-2">
                        <button type="button" class="list-group-item list-group-item-action active">
                            Go to...
                        </button>
                        <a type="button" class="list-group-item list-group-item-action" href="{{ url('/videos') }}">Videos</a>
                        <a type="button" class="list-group-item list-group-item-action" href="{{ url('/users') }}">Users</a>
                    </div>

                    @if(Auth::user()->role=="admin")
                    <div class="card mt-4">
                        <div class="card-header">Send notification</div>

                        <div class="card-body">
                            <form method="GET" action="{{ url('/sendnotification') }}" class="mt-2">
                                @csrf
                                <div class="form-group row">
                                    <label for="subject" class="col-md-4 col-form-label text-md-right">Subject</label>
                                    <div class="col-md-6">
                                        <input id="subject" type="text" class="form-control" name="subject" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="reason" class="col-md-4 col-form-label text-md-right">Reason</label>
                                    <div class="col-md-6">
                                        <textarea id="reason" class="form-control" name="reason" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

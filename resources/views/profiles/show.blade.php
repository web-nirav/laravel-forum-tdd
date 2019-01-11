@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>

            <div class="col-md-8">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                    <hr>
                </div>
                @foreach ($threads as $thread)
                    <div class="card mb-5">
                        <div class="card-header">
                            <div class="level">
                                <span class="flex">
                                    <a href="{{ $thread->creator->profile() }}">{{ $thread->creator->name }}</a> posted:
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{$thread->body}}
                        </div>
                    </div>
                @endforeach
                <div>
                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
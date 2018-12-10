@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 mb-4">

            <div class="card mb-5">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted:
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    {{$thread->body}}
                </div>
            </div>

            @foreach ($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @auth
                <form method="POST" action="{{ route('replies.store', [$channelId, $thread->id]) }}">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" rows="5" placeholder="Have something to say?" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a>  to participate in this discussion.</p>
            @endauth
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This thread was published: {{ $thread->created_at->diffForHumans() }} by 
                    <a href="#">{{ $thread->creator->name }}</a>, and currently 
                    has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count)}}.
                </div>
            </div>
        </div>

    </div>

  

    

</div>
@endsection
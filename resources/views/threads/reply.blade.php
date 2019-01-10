<div class="mb-4">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="{{ $reply->owner->profile() }}">{{ $reply->owner->name }}</a> 
                said {{$reply->created_at->diffForHumans()}}...
            </h5>
            <div>
                <form method="POST" action="{{ url("replies/{$reply->id}/favorites") }}">
                    @csrf
                    <button class="btn btn-default" type="submit" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                        {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count ) }}
                    </button>
                </form>
            </div>
        </div>
        
    </div>

    <div class="card">
        <div class="card-body">
            {{$reply->body}}
        </div>
    </div>
</div>
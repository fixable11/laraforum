<div class="card-header" style="margin-top: 50px">
    <div class="cardOwn">
        <div class="cardOwn__left">
            <a class="cardOwn__link" href="#">{{ $reply->owner->name }}</a>
            said {{ $reply->created_at->diffForHumans() }}
        </div>
        <div class="cacardOwn__right">
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                @csrf
                <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
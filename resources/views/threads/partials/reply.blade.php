<div class="replyWrap">
    <div id="reply-{{ $reply->id }}" class="card-header" style="margin-top: 50px">
        <div class="cardOwn">
            <div class="cardOwn__left">
                <a class="cardOwn__link" href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a>
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
    <div class="card reply">

        <div class="card-body">
            <div class="reply__body">{{ $reply->body }}</div>
            <form class="reply__form d-n" method="POST" action="/replies/{{ $reply->id }}">
                @csrf
                @method('PUT')
                <textarea class="form-control reply__editArea" name="body" id="reply-body" rows="4"></textarea>
                <div class="reply__buttonsArea">
                    <button type="submit" class="reply__btnUpdate btn-update btn btn-info btn-sm">Update</button>
                    <button class="reply__btnCancel btn-cancel btn btn-secondary btn-sm">Cancel</button>
                </div> 
            </form>
        </div>

        {{-- @can('update', $reply) --}}
            <div class="card-footer card-footer_own">
                <button class="reply__btnEdit btn-edit btn btn-sm btn-primary">Edit</button>

                <form class="reply__form_delete" method="POST" action="/replies/{{ $reply->id }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="reply__btnDelete btn-delete btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        {{-- @endcan --}}
        
    </div>
</div>
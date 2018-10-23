<div class="card-header" style="margin-top: 50px">
    <a href="#">{{ $reply->owner->name }}</a>
    said {{ $reply->created_at->diffForHumans() }}
</div>
<div class="card">
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
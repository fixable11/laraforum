<div class="card categoryBlock">
    <div class="card-header">{{ ucfirst($category->name) }}</div>
    <ul class="list-group list-group-flush categoryBlock__ul">
        @forelse ($category->channels as $channel)
            <li class="list-group-item categoryBlock__li">
                <div class="categoryBlock__liLeft">
                    <i class="categoryBlock__fa fas fa-comments"></i> 
                </div>
                <div class="categoryBlock__liRight">
                    <a href="{{ route('threads.index', [
                        'category' => $category->slug,
                        'channel' => $channel->slug, 
                    ]) }}" class="categoryBlock__link">
                        {{ ucfirst($channel->name) }}
                    </a>
                    <div class="categoryBlock__desc">{{ $channel->description}}</div>
                </div>
            </li>
        @empty
            <p>There are no relevant result</p>
        @endforelse
    </ul>
</div>

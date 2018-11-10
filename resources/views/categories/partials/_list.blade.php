<div class="card categoryBlock">
    <div class="card-header">{{ ucfirst($category->name) }}</div>
    <ul class="list-group list-group-flush categoryBlock__ul">
        @forelse ($category->channels as $channel)
            <li class="list-group-item categoryBlock__li">
                <i class="categoryBlock__fa fas fa-comments"></i> 
                <a href="/threads/{{ $channel->slug }}" class="categoryBlock__link">{{ $channel->name }}</a>
            </li>
        @empty
            <p>There are no relevant result</p>
        @endforelse
    </ul>
</div>

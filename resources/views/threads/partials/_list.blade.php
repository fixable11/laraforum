@forelse ($threads as $thread)
<div class="card">
        <div class="card-body">
            <article>
                <div class="level">
                    <div class="thread__left">
                        <h4>
                            <a href="{{ $thread->path() }}">
                                @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                    <strong>
                                        {{ $thread->title }}
                                    </strong>
                                @else
                                    {{ $thread->title }}
                                @endif

                            </a>
                        </h4>
                        <h5 class="thread__creator">Posted By:
                            <a href="{{ route('profile', $thread->creator) }}">
                                {{ $thread->creator->name }}
                            </a>
                        </h5>
                        <div class="level__hr"></div>
                    </div>
                    <div class="thread__right">
                        <a href="{{ $thread->path() }}">
                            {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                        </a>
                    </div>
                </div>
                <div class="body">{{ $thread->body }}</div>
            </article>
        </div>
    </div>
@empty
    <p>There are no relevant result</p>
@endforelse
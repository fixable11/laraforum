@extends('layouts.app')

@section('content')
<thread-view :thread="{{ $thread }}" inline-template v-cloak>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header__flex">
                                <div class="card-header__left">
                                    <img class="card-header__leftImg" src="{{ $thread->creator->avatar_path }}" alt="">
                                    <a class="card-header__leftName" href="{{ route('profile', $thread->creator->name) }}">
                                        {{ $thread->creator->name }}
                                    </a>
                                    <span class="card-header__leftTitle">posted: {{ $thread->title }}</span>
                                </div>
                                <div class="card-header__right">
                                    @can ('update', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary">Delete Thread</button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                {{ $thread->body }}

                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a>, and currently has 
                            <span v-text="repliesCount"></span>
                            {{ str_plural('comment', $thread->replies_count) }}
                        </p>
                        <p>
                            <subscribe-button v-if="signedIn" :initial-state="{{ json_encode($thread->isSubscribedTo) }}" ></subscribe-button>  
                        
                            <button :class="locked ? 'btn-danger' : 'btn-default'" class="btn" v-if="authorize('isAdmin')" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock'"></button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection

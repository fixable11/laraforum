@extends('layouts.app')

@section('content')
<thread-view :thread="{{ $thread }}" inline-template v-cloak>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 order-12 order-lg-1">
                <div class="row">

                    @include('threads.partials._thread')

                    <div class="col-md-12">
                        <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-12">
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

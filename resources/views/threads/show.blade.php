@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header__flex">
                                <div class="card-header__left">
                                    <a href="{{ route('profile', $thread->creator->name) }}">
                                        {{ $thread->creator->name }}
                                    </a>
                                    {{ $thread->title }}
                                </div>
                                <div class="car-header__right">
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
                        <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>
                    </div>
                    {{-- <div class="col-md-12" style="margin-top: 50px">
                        @foreach ($replies as $reply)
                            @include('threads.partials.reply')
                        @endforeach
                    </div>

                    <div class="col-md-12">
                        {{$replies->links()}}
                    </div> --}}

                    <div class="col-md-12" style="margin-top: 50px">
                        @if (auth()->check())
                        <form method="POST" action="{{ $thread->path() . '/replies'}}">
                            @csrf
                            <div class="form-group">
                                <textarea rows="5" placeholder="Body" name="body" class="form-control" id="body" cols="30"
                                    rows="10"></textarea>
                            </div>
                            <button type="submit" class="btn btn-info">Post</button>
                        </form>
                        @else
                        <p class="text-center">Please <a href="{{ route('login')}}">sign in</a> to
                            participate
                            in this dicussion</p>
                        @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection

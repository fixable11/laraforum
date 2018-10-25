@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                            {{ $thread->title }}
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

                <div class="col-md-12" style="margin-top: 50px">
                    @foreach ($replies as $reply)
                    @include('threads.partials.reply')
                    @endforeach
                </div>

                <div class="col-md-12">
                    {{$replies->links()}}
                </div>

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
                    <p clas </div> </div> s="text-center">Please <a href="{{ route('login')}}">sign in</a> to
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
                        <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }}
                        {{ str_plural('comment', $thread->replies_count) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a>
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
    </div>

    <div class="row justify-content-center" style="margin-top:50px">
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)
            @include('threads.partials.reply')
            @endforeach
        </div>
    </div>

    @if (auth()->check())
    <div class="row justify-content-center" style="margin-top:50px">
        <div class="col-md-8">
            <form method="POST" action="{{ $thread->path() . '/replies'}}">
                @csrf
                <div class="form-group">
                    <textarea rows="5" placeholder="Body" name="body" class="form-control" id="body" cols="30" rows="10"></textarea>
                </div>
                <button type="submit" class="btn btn-info">Post</button>
            </form>
        </div>
    </div>
    @else
    <p class="text-center">Please <a href="{{ route('login')}}">sign in</a> to participate in this dicussion</p>
    @endif

</div>
@endsection

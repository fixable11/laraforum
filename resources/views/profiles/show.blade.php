@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>{{ $profileUser->name }}</h1>
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @foreach ($threads as $thread)
            <div class="card card__default">
                <div class="card-header">
                    <a href="{{ route('profile', $thread->creator->name) }}">
                        {{ $thread->creator->name }}
                    </a> posted
                    <a href="{{ $thread->path() }}">
                        {{ $thread->title }}
                    </a>
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            @endforeach

            {{ $threads->links() }}
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            
            @include('threads.partials._list')
            <div class="paginationWrap">
                {{ $threads->links() }}
            </div>
            
        </div>

        <div class="col-md-4">
            @if (count($trending))
                <div class="card">
                    <div class="card-header">
                        Trending Threads
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($trending as $trend)
                                <li class="list-group-item">
                                    <a href="{{url($trend->thread->path())}}">{{ $trend->thread->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

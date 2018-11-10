@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            
            @include('categories.partials._list')
            <div class="paginationWrap">
                
            </div>
            
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    Search
                </div>
                <div class="card-body">
                    <form action="/threads/search" method="GET" class="searchForm">
                        <input class="form-control searchForm__field" name="q" type="text" placeholder="What are we looking for?">
                        <button type="submit" class="btn btn-default searchForm__submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>

            @if (count($trending))
                <div class="card">
                    <div class="card-header">
                        Trending Threads
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($trending as $trend)
                                <li class="list-group-item">
                                    <a href="{{url($trend->path())}}">{{ $trend->title }}</a>
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

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @include('threads.partials._list')
            <div class="paginationWrap">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

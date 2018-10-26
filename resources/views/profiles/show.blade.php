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
            @foreach ($activities as $date => $activity)
                <h3 class="page-header">{{ $date }}</h3>
                <hr>
                @foreach ($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @endforeach

            {{-- {{ $activity->links() }} --}}
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <avatar-form :user="{{ $profileUser }}"></avatar-form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @forelse ($activities as $date => $activity)
                <h3 class="page-header">{{ $date }}</h3>
                <hr>
                @foreach ($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endif
                @endforeach
            @empty
                <p>There is no activity for this user yet.</p>
            @endforelse

            {{-- {{ $activity->links() }} --}}
        </div>
    </div>
</div>

@endsection
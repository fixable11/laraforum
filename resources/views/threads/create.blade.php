@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form method="POST" action="/threads">
                        @csrf

                        <div class="form-group">
                            <label for="channel_id">Choose a channel</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose one..</option>

                                @foreach ($channels as $channel)
                                <option value="{{ $channel->id }}"
                                    {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                    {{ $channel->name }}
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input required value="{{ old('title') }}" name="title" type="text" id="title" class="form-control"
                                placeholder="title">
                        </div>

                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea required name="body" type="text" id="body" class="form-control" placeholder="body">{{ old('body') }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>

                        @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

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
                            <wysiwyg name="body"></wysiwyg>
                            {{-- <textarea required name="body" type="text" id="body" class="form-control" placeholder="body">{{ old('body') }}</textarea> --}}
                        </div>

                        <div class="g-recaptcha" data-sitekey="6Lf6q3kUAAAAAGZoRa4qoRZ1W0lPOk7p2IL-4CLK"></div>

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

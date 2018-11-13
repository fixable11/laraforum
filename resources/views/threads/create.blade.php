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
                            <label for="title">Title:</label>
                            <input required value="{{ old('title') }}" name="title" type="text" id="title" class="form-control"
                                placeholder="title">
                        </div>
                        
                        <choose-category 
                        :selected-category="{{ !empty(old('category_id')) ? old('category_id') : '0' }}"
                        :selected-channel="{{ !empty(old('channel_id')) ? old('channel_id') : '0' }}"
                        :categories="{{ $categories }}" 
                        :channels="{{ $channels }}">
                        </choose-category>
                        
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <wysiwyg name="body" value="{{ old('body') }}"></wysiwyg>
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

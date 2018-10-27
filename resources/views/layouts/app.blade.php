<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style>
</style>

<body style="padding-bottom: 100px;">
    <div id="app">
        @include('layouts.nav')

        <main class="py-4">
            @yield('content')
        </main>
        
        <div class="app-alert-success alert-own alert alert-success d-n">
            <strong>Success </strong>{{session('flash')}}
        </div>

        <div class="app-alert-error alert-own alert alert-danger d-n">
            <strong>Error </strong>{{session('error')}}
        </div>

        @if (session()->has('flash'))
            <div class="alert-flash alert-own alert alert-success">
                <strong>Success </strong>{{session('flash')}}
            </div>
        @endif
        
    </div>
</body>

</html>

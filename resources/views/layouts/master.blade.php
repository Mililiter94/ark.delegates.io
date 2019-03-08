<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        {{-- Meta --}}
        @hasSection('meta')
            @yield('meta')
        @else
            <meta name="description" itemprop="description" content="Easily find out who is a delegate, what they do and can offer the ecosystem." />
            <meta name="keywords" content="ark,delegates,crypto,currency,dpos,voters" />
            <meta name="og:description" content="Easily find out who is a delegate, what they do and can offer the ecosystem." />
            <meta property="og:title" content="{{ config('app.name') }}" />
            <meta property="og:url" content="{{ url()->current() }}" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="{{ app()->getLocale() }}" />
            {{-- <meta property="og:locale:alternate" content="en-us" /> --}}
            <meta property="og:site_name" content="{{ config('app.name') }}" />
            {{-- <meta property="og:image" content="https://ark.delegates.io/cover.jpg" /> --}}
            {{-- <meta property="og:image:url" content="https://ark.delegates.io/cover.jpg" /> --}}
            {{-- <meta property="og:image:size" content="300" /> --}}
        @endif
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@arkx">
        <meta name="twitter:title" content="{{ config('app.name') }}">
        <meta name="twitter:description" content="Easily find out who is a delegate, what they do and can offer the ecosystem.">
        {{-- Styles --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/github-markdown.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">
        <link rel="shortcut icon" href="{{ asset('favicon.png')}}">
        @include('layouts.partials.cookie-consent')
        @stack('styles')
    </head>

    <body class="font-sans">
        <div id="app">
            {{ $slot }}
        </div>
    </body>

    <script src={{ asset('js/app.js') }}></script>
    @stack('scripts')

    @auth
        @include('layouts.partials.beacon')
    @endauth
</html>

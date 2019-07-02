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
    <div data-type="countdown" data-id="1295602" class="tickcounter" style="width: 100%; position: relative; padding-bottom: 25%"><a href="//www.tickcounter.com/countdown/1295602/qredit-delegate-update" title="Qredit Delegate Update">Qredit Delegate Update</a><a href="//www.tickcounter.com/" title="Countdown">Countdown</a></div><script>(function(d, s, id) { var js, pjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//www.tickcounter.com/static/js/loader.js"; pjs.parentNode.insertBefore(js, pjs); }(document, "script", "tickcounter-sdk"));</script>
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

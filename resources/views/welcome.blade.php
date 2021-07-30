<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

    <title>Laravel</title>
</head>
<body>
<div class="top-bar">
    <span class="title">mcd</span>
    <span class="bar-link"><a href="{{ route('home') }}">Dashboard</a></span>
    <span class="bar-link"><a href="{{ route('chat') }}">Chat</a></span>
    <span class="bar-link"><a href="{{ route('boards') }}">Boards</a></span>
    <span class="menu-link">
    @if (auth()->user())
        {{ auth()->user()->name }}
    @else
        Menu
    @endif
    </span>

    @yield('top-bar')
</div>

<div class="content">
    @yield('content')
</div>

<div class="footer">
    @yield('footer')
</div>

@yield('javascript')
</body>
</html>

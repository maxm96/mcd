<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

    <title>mcd</title>
</head>
<body>
<div class="top-bar">
    <span class="title">mcd</span>
    <span class="bar-link"><a href="{{ route('home') }}">Home</a></span>
    <span class="bar-link"><a href="{{ route('chat') }}">Chat</a></span>
    <span class="bar-link"><a href="{{ route('boards') }}">Boards</a></span>

    @php $loggedIn = auth()->check(); @endphp

    <div class="menu-link dropdown">
        <span onclick="showDropdown()" class="drop-btn">{{ $loggedIn ? auth()->user()->name : 'Menu' }}</span>
        <div id="menu-dropdown" class="dropdown-content">
            @if ($loggedIn)
                <a href="{{ route('account_settings') }}">Account settings</a>
                <a href="{{ route('logout') }}">Logout</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endif
        </div>
    </div>

    @yield('top-bar')
</div>

<div class="content">
    @yield('content')
</div>

<div class="footer">
    @yield('footer')
</div>

<script type="text/javascript">
    // Show dropdown menu
    function showDropdown() {
        document.getElementById('menu-dropdown').classList.toggle('show')
    }

    // Close dropdown menu when clicked outside
    window.onclick = function (e) {
        if (e.target.matches('.drop-btn')) {
            return
        }

        Array.from(document.getElementsByClassName('dropdown-content')).forEach(function (dc) {
            dc.classList.remove('show')
        })
    }
</script>

@yield('javascript')
</body>
</html>

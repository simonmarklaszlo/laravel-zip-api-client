<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Laravel ZIP API')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<nav style="margin-bottom:1rem;">
    <a href="{{ url('/') }}" style="margin-right:1rem;">Kezdőlap</a>
    <a href="{{ route('cities.index') }}">Városok</a>
</nav>

<main style="padding: 1rem;">
    @yield('content')
</main>
</body>
</html>


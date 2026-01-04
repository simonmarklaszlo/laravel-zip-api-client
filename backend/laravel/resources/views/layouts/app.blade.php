<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Laravel ZIP API')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        nav {
            background-color: #007bff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 1.5rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: rgba(255,255,255,0.2);
        }
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            color: #007bff;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #007bff;
        }
        select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            min-width: 200px;
        }
        label {
            font-weight: bold;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
<nav>
    <a href="{{ url('/') }}">🏠 Kezdőlap</a>
    <a href="{{ route('cities.index') }}">🏙️ Városok</a>
</nav>

<main>
    @yield('content')
</main>
</body>
</html>


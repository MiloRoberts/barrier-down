<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barrier Down</title>
    <link rel="stylesheet" href="/css/app.css">
    <!-- <script src="/js/app.js"></script> -->
</head>
<body>
    <!-- below means only if the user is a user like if (auth()->check()) -->
    <!-- guest can be used the same way -->
    @auth
        <span>Welcome, {{ Auth::user()->name }}</span>
        <!-- alternative below -->
        <!-- <span>Welcome, {{ auth()->user()->name }}</span> -->
        <form action="/logout" method="post">
            @csrf

            <button type="submit">Log Out</button>
        </form>
    @else
        <a href="/register">Register</a>
        <a href="/login">Log In</a>
    @endauth

    {{ $slot }}
    
    @if (session()->has('success'))
        <div>
            <!-- this will need to get styled like in episode 48 -->
            <!-- use javascript to make message disappear after set timeframe also like in episode 48 -->
            <!-- finally, turn it into its own blade component -->
            <p>{{ session()->get('success') }}</p>
            <!-- below is alternative using key instead -->
            <!-- <p>{{ session('success') }}</p> -->
        </div>
    @endif
</body>
</html>
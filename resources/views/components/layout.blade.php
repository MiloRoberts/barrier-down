<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barrier Down</title>
    <link rel='stylesheet' href='/css/main.css' />
    <link rel='stylesheet' href='/css/fontello.css' />
    {{ $styling }}
</head>
<body>
    <header>
      <nav id='nav-bar'>
        <a id='nav-logo' href='/index.php'
          >Barrier<span id='logo-span-right'>Down</span></a
        >
        <div id='nav-burger' onclick='toggleBurgerLinks()'>
          <i class='icon-menu' id='icon-menu'></i>
          <i class='icon-cancel hidden' id='icon-cancel'></i>
        </div>
        <a class='nav-link' href='/profile'>Settings</a>
        <a class='nav-link' href='/games'>Games</a>
        <a class='nav-link' href='/flashcards'>Flashcards</a>
        <a class='nav-link' href='/about'>About</a>
        <a class='nav-link' href='/logout'>Sign Out</a>
      </nav>
      <nav id='nav-burger-links'>
        <ul>
          <li>
            <a class='burger-link' href='/settings'>Settings</a>
          </li>
          <li>
            <a class='burger-link' href='/games'>Games</a>
          </li>
          <li>
            <a class='burger-link' href='/flashcards'>Flashcards</a>
          </li>
          <li>
            <a class='burger-link' href='/about'>About</a>
          </li>
          <li>
            <a class='burger-link' href='/logout'>Sign Out</a>
          </li>
        </ul>
      </nav>
    </header>
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

    {{ $content }}
    
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
    <script src='/javascript/main.js'></script>
</body>
</html>
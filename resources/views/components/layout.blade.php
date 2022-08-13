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
        <a id='nav-logo' href='/'
          >Barrier<span id='logo-span-right'>Down</span></a
        >
        <div id='nav-burger' onclick='toggleBurgerLinks()'>
          <i class='icon-menu' id='icon-menu'></i>
          <i class='icon-cancel hidden' id='icon-cancel'></i>
        </div>
        <a class='nav-link' href='/games'>Games</a>
        <a class='nav-link' href='/flashcards'>Flashcards</a>
        <a class='nav-link' href='/about'>About</a>
        <!-- below means only if the user is a user like if (auth()->check()) -->
        <!-- guest can be used the same way -->        
        @auth
            <!-- <span>Welcome, {{ Auth::user()->name }}</span> -->
            <!-- alternative below -->
            <!-- <span>Welcome, {{ auth()->user()->name }}</span> -->
            <a class='nav-link' href="/settings">Settings</a>
            <form class="nav-form" action="/logout" method="post">
                @csrf
                <button class="nav-button" type="submit">Sign Out</button>
            </form>
        @else
            <a class='nav-link' href="/register">Register</a>
            <a class='nav-link' href="/login">Sign In</a>
        @endauth
      </nav>
      <nav id='nav-burger-links'>
        <ul>
          <li>
            <a class='burger-link' href='/games'>Games</a>
          </li>
          <li>
            <a class='burger-link' href='/flashcards'>Flashcards</a>
          </li>
          <li>
            <a class='burger-link' href='/about'>About</a>
          </li>
            @auth
                <li>
                    <a class='burger-link' href="/settings">Settings</a>
                </li>
                <form class="burger-form" action="/logout" method="post">
                    @csrf
                    <li>
                        <button class="burger-button" type="submit">Sign Out</button>
                    </li>
                </form>
            @else
                <li>
                    <a class='nav-link' href="/register">Register</a>
                </li>    
                <li>
                    <a class='nav-link' href="/login">Sign In</a>
                </li>
            @endauth
        </ul>
      </nav>
    </header>
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
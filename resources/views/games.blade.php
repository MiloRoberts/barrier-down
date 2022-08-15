<x-layout>
    <x-slot name="styling">
        <link rel="stylesheet" href="/css/games.css">
    </x-slot>
    <x-slot name="content">

        <h2 class='special-heading-dark'>— Games —</h2>

        <div id='games-single-rows'>
            @foreach ($games as $game)
            <!-- <div class='main-container'> -->
                <a class='game-link' href='/games/{{ $game->slug }}'>
                    <div class='game-container'>
                        <p>{{ $game->game_title->english_title }}</p>
                        <img
                        src='/images/{{ $game->slug }}-00-lg.png'
                        alt='{{ $game->game_title->english_title }} title screen image'
                        />
                    </div>
                </a>
            <!-- </div> -->
                @endforeach
        </div>

        <div id='games-double-rows'>
            @foreach ($games as $game)
            <!-- <div class='main-container'> -->
                <a class='game-link' href='/games/{{ $game->slug }}'>
                    <div class='game-container'>
                        <p>{{ $game->game_title->english_title }}</p>
                        <img
                        src='/images/{{ $game->slug }}-00-lg.png'
                        alt='{{ $game->game_title->english_title }} title screen image'
                        />
                    </div>
                </a>
            <!-- </div> -->
                @endforeach
        </div>

    </x-slot>
</x-layout>
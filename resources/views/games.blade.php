<x-layout>
    <x-slot name="styling">
        <link rel="stylesheet" href="/css/games.css">
    </x-slot>
    <x-slot name="content">

        <h2 class='special-heading-dark'>— Games —</h2>
        
        <!-- @foreach ($games as $game)
            <h3>
                <a href="/games/{{ $game->slug }}">
                    {{ $game->game_title->english_title }}
                </a>
            </h3>
            <h3>
                {{ $game->game_title->japanese_title }}
            </h3>
            <h3>
                <a href="/gameconsoles/{{ $game->game_console->slug }}">
                    {{ $game->game_console->console_manufacturer->manufacturer }} 
                    <span>
                        {{ $game->game_console->console_name->name }}
                    </span>
                </a>
            </h3>
            <hr>
        @endforeach -->

        <div id='games-single-rows'>
        <a class='game-link' href='./culdcept.php'>
            <div class='main-container'>
            <div class='culdcept game-container'>
                <p>Culdcept</p>
                <img
                src='./images/culdcept_saturn_00_large.png'
                alt='Culdcept title screen'
                />
            </div>
            </div>
        </a>
        <a class='game-link' href='./puyoPuyoTsuu.php'>
            <div class='puyo-puyo-tsuu game-container'>
            <img
                src='./images/puyo_puyo_2_remix_snes_00_large.png'
                alt='Puyu Puyo Tsuu title screen'
            />
            <p>Puyo Puyo Tsuu</p>
            </div>
        </a>
        </div>
        <div id='games-double-rows'>
        <a class='game-link' href='./culdcept.php'>
            <div class='main-container'>
            <div class='culdcept game-container'>
                <p>Culdcept</p>
                <img
                src='./images/culdcept_saturn_00_large.png'
                alt='Culdcept title screen'
                />
            </div>
            </div>
        </a>
        <a class='game-link' href='./puyoPuyoTsuu.php'>
            <div class='puyo-puyo-tsuu game-container'>
            <p>Puyo Puyo Tsuu</p>
            <img
                src='./images/puyo_puyo_2_remix_snes_00_large.png'
                alt='Puyu Puyo Tsuu title screen'
            />
            </div>
        </a>
        </div>

    </x-slot>
</x-layout>
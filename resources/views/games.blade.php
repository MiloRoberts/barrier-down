<x-layout>
    <x-slot name="styling">
        <link rel='stylesheet' href='./css/games.css' />
    </x-slot>
    <x-slot name="content">
        @foreach ($games as $game)
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
        @endforeach
    </x-slot>
</x-layout>
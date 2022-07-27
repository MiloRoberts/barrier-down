<x-layout>
    <h1>
        <a href="/games/{{ $game->slug }}">
            {{ $game->title}}
        </a>
    </h1>
    <p>
        {!! $game->body !!}
    </p>
</x-layout>
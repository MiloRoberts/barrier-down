<x-layout>
    <h1>
        <a href="/games/{{ $game->id }}">
            {{ $game->title}}
        </a>
    </h1>
    <p>
        {!! $game->body !!}
    </p>
</x-layout>
<x-layout>
    <!-- don't forget later to extract all of this for the loop -->
    @php
        $games = \App\Models\Games::all();
    @endphp

    <select name="games" id="games">
        @foreach($games as $game)
            <option value="{{ $games->id }}">{{ $games->game_titles.english_title}} {{ $games->game_consoles->console_manufacturers.manufacturer }} {{ $games->game_consoles->name }}</option>
        @endforeach
    </select>
<x-layout>
<x-layout>
    <x-slot name="styling">
        <link rel="stylesheet" href="/css/individualGames.css">
    </x-slot>  
    <x-slot name="content">

        <picture class="title-screen">
        <source
            srcset="/images/{{ $game->slug }}-00.png"
            media="(min-width: 604px)"
        />
        <source
            srcset="/images/{{ $game->slug }}-00-lg.png"
            media="(min-width: 906px)"
        />
        <img src="/images/{{ $game->slug }}-00-sm.png" />
        </picture>
        <h2 class='special-heading-bright'>{{ $game->game_title->english_title }}</h2>
        <h3>What's <em>{{ $game->game_title->english_title }}</em>?</h3>
        {!! $game->info !!}
        <div id='slideshow-container'>
            @for ($i = 1; $i <= 6; $i++)
                <div class='slideshow-image-container'>
                    <img src='/images/{{ $game->slug }}-0{{ $i }}-sm.png' alt='{{ $game->game_title->english_title }} screenshot #{{ $i }}' />
                </div>
            @endfor
        </div>
        <div id="gallery-container">
            <div class="gallery-row">
                @for ($i = 1; $i <= 3; $i++)
                <div class="gallery-column">
                        <img
                            src="/images/{{ $game->slug }}-0{{ $i }}.png"
                            alt="{{ $game->game_title->english_title }} screenshot #{{ $i }}"
                            onclick="showGallery(this)"
                        />
                    </div>
                    @endfor
            </div>
            <div id="enlarged-image-container">
                <img src="/images/{{ $game->slug }}-01.png" alt="" id="enlarged-image" />
            </div>
            <div id="alt-gallery-column">
                @for ($i = 4; $i <= 6; $i++)
                    <div class="gallery-column">
                        <img
                            src="/images/{{ $game->slug }}-0{{ $i }}.png"
                            alt="{{ $game->game_title->english_title }} screenshot #{{ $i }}"
                            onclick="showGallery(this)"
                        />
                    </div>
                @endfor
            </div>
        </div>
        <!-- <div id='add-culdcept-expansion' class='add-game-button'>
        Start Learning
        </div>
        <div id='remove-culdcept-expansion' class='remove-game-button'>
        Stop Learning
        </div>  -->
    <script src="/javascript/individualGames.js"></script>

    </x-slot>
</x-layout>
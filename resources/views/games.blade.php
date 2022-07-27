<x-layout>
    @foreach ($games as $game)
        <h1>
            <?php echo $game->title; ?>
        </h1>
    @endforeach
</x-layout>
<x-layout>
<!--    games.slug (english_title-name-manufacturer)
        game_consoles.slug (name-manufacturer) -->
    <form action="/admin/games" method="post">
        @csrf
        <!-- game_titles.english_title -->
        <label for="english-title">
            English Title
        </label>
        <input type="text" name="english-title" id="english-title">
        <!-- game_titles.japanese_title -->
        <label for="japanese-title">
            Japanese Title
        </label>
        <input type="text" name="japanese-title" id="japanese-title">
        <!-- games.info -->
        <label for="info">
            Game Info
        </label>
        <textarea name="info" id="info" rows="20" cols="100"></textarea>
        <!-- console_manufacturers.manufacturer -->
        <label for="manufacturer">
            Console Manufacturer
        </label>
        <input type="text" name="manufacturer" id="manufacturer">
        <!-- console_names.name -->
        <label for="name">
            Console Name
        </label>
        <input type="text" name="name" id="name">
        <button type="submit">Submit</button>
    </form>
</x-layout>
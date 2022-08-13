<x-layout>
    <x-slot name="styling">
        <link rel="stylesheet" href="/css/about.css">
    </x-slot>
    <x-slot name="content">
        <h2 class="special-heading-bright">About</h2>
        <h3>The Website</h3>
        <h4>What is BarrierDown?</h4>
        <p>
            BarrierDown is a website built with the purpose of assisting those who
            wish to play Japanese games <span class="italic-span">in Japanese</span>.
            It saves visitors the need to look up words as they play by giving them
            everything up-front like flashcards and helpful notes.
        </p>
        <h3>FAQs</h3>
        <h4>Does it have translations?</h4>
        <p>
            No, this is made with a more "teach a person to fish..." sort of mentality
            which translations would run contrary to. If, however, you wish to use the
            resources provided here to produce a translation of your own, by all
            means, go for it!
        </p>
        <h4>When will the next update be?</h4>
        <p>
            Unfortunately, I'm doing this by myself and in my free time, so updates
            will be few and far between. News of any updates will be sent out via
            email to those who've subscribed to the mailing list.
        </p>
        <!-- get rid of inline styling and place license info in About page -->
        <div>
            <h3>Credits</h3>
            <h4>Font license info</h4>
            <p>## Font Awesome</p>
            <p>Copyright (C) 2016 by Dave Gandy</p>
            <p>Author: Dave Gandy</p>
            <p>License: SIL ()</p>
            <p>Homepage: http://fortawesome.github.com/Font-Awesome/</p>
        </div>
        <script src="./javascript/main.js"></script>
    </x-slot>
</x-layout>
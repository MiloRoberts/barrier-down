<x-layout>
    <x-slot name="styling">
        <link rel="stylesheet" href="/css/flashcards.css">
    </x-slot>
    <x-slot name="content">
        @guest
            <h3>You must have an account to use the flashcard program.</h3>
        @else
            <div id='initial-screen'>
                <table>
                    <tr>
                        <td>
                        <input id='select-all-checkbox' type='checkbox' />
                        </td>
                        <td>Select / Unselect All</td>
                    </tr>
                    </table>
                <h2>Games</h2>
                    <table>
                    <thead>
                        <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Console</th>
                        </tr>
                    </thead>
                    <tbody>

                <?php    

                function setInitialElements() {
                
                    error_reporting(E_ERROR);
                    try {
                        
                    $dataToSend = "";

                    $sqlQuery = "SELECT DISTINCT games.id, learning, english_title, japanese_title, console 
                    FROM games
                    INNER JOIN games_users ON games.id = games_users.game_id
                    INNER JOIN game_titles ON games.game_title_id = game_titles.id
                    INNER JOIN game_consoles ON games.game_console_id = game_consoles.id
                    WHERE `user_id` = '" . Auth::user()->id . "' AND games_users.learning = 1;";

                    $result = DB::select($sqlQuery);

                    foreach($result as $row) {
                    $dataToSend .= "<tr id='G" . $row->id . "'>
                    <td rowspan='2'><input type='checkbox' name='game-checkbox'/></td>
                    <td class='smaller'>" . $row->japanese_title . "</td>
                    <td rowspan='2'>" . $row->console . "</td>
                    </tr>
                    <tr class='border-bottom'>
                    <td>" . $row->english_title . "</td>
                    </tr>";
                    }

                    $dataToSend .= "</tbody>
                    </table>
                    <button type='button' id='begin-button' data-csrf='" . csrf_token() . "' >Begin</button>
                    </div>
                    <div id='flashcard-screen' class='hidden'>
                    <div id='' class='flashcard'>
                    <div id='lexeme-item'>
                        <h1 id='flashcard-item'></h1>
                    </div>
                    <div id='lexeme-meaning'>
                        <h4 id='flashcard-meaning' class='invisible'></h4>
                    </div>
                    <div id='lexeme-reading'>
                        <h2 id='flashcard-reading' class='invisible'></h2>
                    </div>
                    <div id='lexical-class'>
                        <h4 id='flashcard-class'></h4>
                    </div>
                    </div>
                    <div class='flexContainer'>
                    <div id='difficulty1' class='difficulty hidden'>easy</div>
                    <div id='difficulty2' class='difficulty hidden'></div>
                    <div id='difficulty3' class='difficulty hidden'></div>
                    <div id='difficulty4' class='difficulty hidden'></div>
                    <div id='difficulty5' class='difficulty hidden'>hard</div>
                    </div>
                    </div>
                    <div id='instructions-screen' class='hidden'>
                    <h3>After flipping over a flashcard, pressing one of the buttons towards the right will make the flashcard appear again sooner; pressing one of those towards the left will make it do so later.</h3>
                    <button type='button' id='instructions-understood-button'>Got It!</button>
                    </div>
                    <button type='button' id='flip-flashcard-button' class='hidden'>Flip Flashcard</button>
                    <button type='button' id='view-kanji-button' class='hidden' data-csrf='" . csrf_token() . "'>View Kanji</button>
                    <button type='button' id='stop-learning-button' class='hidden'>Stop Learning</button>
                    <div id='stop-learning-screen' class='hidden'>
                    <h3>This will remove this item from the list of words you're learning.</h3>
                    <h3>Do you wish to continue?</h3>
                    <button type='button' id='yes-button' data-csrf='" . csrf_token() . "'>Yes</button>
                    <button type='button' id='no-button'>No</button>
                    </div>
                    <div id='kanji-info' class='hidden'></div>
                    <button type='button' id='go-back-button' class='hidden'>Go Back</button>
                    <script src='/javascript/flashcards.js'></script>
                    </body>
                    </html>";

                    } catch (Exception $exceptionError) {
                        echo $exceptionError->getMessage();
                    }
                    echo $dataToSend;
                }

                setInitialElements();
                ?>
        @endguest
    </x-slot>
</x-layout>



  

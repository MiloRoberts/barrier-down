<x-layout>
    <x-slot name="styling">
        <link rel='stylesheet' href='/css/settings.css' />
    </x-slot>
    <x-slot name="content">
        @guest
            <h3>You must have an account to visit this page.</h3>
        @else
            <?php
            // function displaySubscriptionStatus() {
            //     error_reporting(E_ERROR);
            //     try {
            //         $dataToSend = "";

            //         $dataToSend .= "<h2 class='special-heading-bright'>Settings</h2>
            //     <h2>User</h2>
            //     <table>
            //     <tr id='mailing-list'>
            //         <td rowspan='1'>";

            //     $sqlQuery = "SELECT subscriber FROM user WHERE `user_id` = " . Auth::user()->id . ";";

            //     $result = DB::select($sqlQuery);

            //         foreach($result as $row) {
            //             if ($row["subscriber"] == 1) {
            //             $dataToSend .= "<input type='checkbox' id='mailing-list-checkbox' name='mailing-list-checkbox' checked />";
            //             } else {
            //             $dataToSend .= "<input type='checkbox' id='mailing-list-checkbox' name='mailing-list-checkbox' />";
            //             }
            //         }

            //         $dataToSend .= "<td rowspan='2'>Subscribe to Mailing List</td>
            //     </tr>
            //     </table>";

            //     } catch (Exception $exceptionError) {
            //         echo $exceptionError->getMessage();
            //     }
            //     echo $dataToSend;
            // }

            function displayGames() {
                error_reporting(E_ERROR);
                try {
                    
                    $dataToSend = "";

                    $dataToSend = "<h2>Games</h2>
                <table>
                <thead>
                    <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Console</th>
                    </tr>
                </thead>
                <tbody>";

                    // this gets the non-null values
                    $sqlQuery = "SELECT DISTINCT games.id, learning, english_title, japanese_title, console 
                    FROM games
                INNER JOIN games_users ON games.id = games_users.game_id
                INNER JOIN game_titles ON games.game_title_id = game_titles.id
                INNER JOIN game_consoles ON games.game_console_id = game_consoles.id
                WHERE `user_id` = " . Auth::user()->id . ";";

                    $result = DB::select($sqlQuery);

                    foreach($result as $row) {
                        if ($row->learning) {
                            $dataToSend .= "<tr id='G" . $row->id . "'>
                            <td rowspan='2'><input type='checkbox' name='game-checkbox' checked /></td>
                            <td class='smaller'>" . $row->japanese_title . "</td>
                            <td rowspan='2'>" . $row->console . "</td>
                            </tr>
                            <tr class='border-bottom'>
                            <td>" . $row->english_title . "</td>
                            </tr>";
                        } else {
                            $dataToSend .= "<tr id='G" . $row->id . "'>
                            <td rowspan='2'><input type='checkbox' name='game-checkbox'/></td>
                            <td class='smaller'>" . $row->japanese_title . "</td>
                            <td rowspan='2'>" . $row->console . "</td>
                            </tr>
                            <tr class='border-bottom'>
                            <td>" . $row->english_title . "</td>
                            </tr>";
                        }
                    }

                    $dataToSend .= "</tbody>
                </table>";

                } catch (Exception $exceptionError) {
                    echo $exceptionError->getMessage();
                }
                echo $dataToSend;
            }

            function displayLexemes() {
                error_reporting(E_ERROR);
                try {
                    
                    $dataToSend = "";

                    $dataToSend .= "<h2>Vocabulary</h2>
                <table>
                <thead>
                    <tr>
                    <th></th>
                    <th>Item</th>
                    <th>Meaning</th>
                    </tr>
                </thead>
                <tbody>";

                    // this gets the non-null values
                    $sqlQuery = "SELECT lexemes.id, learning, item, meaning, reading FROM lexemes_users, lexemes, lexeme_items, lexeme_meanings, lexeme_readings WHERE `user_id` = " . Auth::user()->id . " AND lexemes.id = lexemes_users.lexeme_id AND lexemes.lexeme_item_id = lexeme_items.id AND lexemes.lexeme_meaning_id = lexeme_meanings.id AND lexemes.lexeme_reading_id = lexeme_readings.id;";
                    
                    // switch to this updated version

                    // needs testing first

                    // $sqlQuery = "SELECT lexeme.lexeme_id, item, meaning, reading FROM lexeme INNER JOIN lexeme_item ON lexeme.lexeme_item_id = lexeme_item.lexeme_item_id INNER JOIN user_lexeme ON lexeme.lexeme_id = user_lexeme.lexeme_id INNER JOIN lexeme_meaning ON lexeme.lexeme_meaning_id = lexeme_meaning.lexeme_meaning_id INNER JOIN lexeme_reading ON lexeme.lexeme_reading_id = lexeme_reading.lexeme_reading_id WHERE user_lexeme.user_id = 3 AND user_lexeme.learning = 1;";

                    $result = DB::select($sqlQuery);

                    foreach($result as $row) {
                        if ($row->learning) {
                            $dataToSend .= "<tr id='L" . $row->lexeme_id . "'>
                            <td rowspan='2'><input type='checkbox' name='lexeme-checkbox' checked/></td>
                            <td class='smaller'>" . $row->reading . "</td>
                            <td rowspan='2'>" . $row->meaning . "</td>
                            </tr>
                            <tr class='border-bottom'>
                            <td>" . $row->item . "</td>
                            </tr>";
                        } else {
                            $dataToSend .= "<tr id='L" . $row->lexeme_id . "'>
                            <td rowspan='2'><input type='checkbox' name='lexeme-checkbox'/></td>
                            <td class='smaller'>" . $row->reading . "</td>
                            <td rowspan='2'>" . $row->meaning . "</td>
                            </tr>
                            <tr class='border-bottom'>
                            <td>" . $row->item . "</td>
                            </tr>";
                        }
                    }

                    $dataToSend .= "</tbody>
                </table>
                <script src='./javascript/settings.js'></script>
            </body>
            </html>";

                } catch (Exception $exceptionError) {
                    echo $exceptionError->getMessage();
                }
                echo $dataToSend;
            }

            displaySubscriptionStatus();

            displayGames();

            displayLexemes();
            ?>
        @endguest
    </x-slot>
</x-layout>
<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class GamesUsersController extends Controller
{
    public function store() {

        $gameID = $_POST['gameID'];

        error_reporting(E_ERROR);
            try {

                $sqlQuery = "UPDATE lexemes_users
                INNER JOIN lexemes ON lexemes_users.lexeme_id = lexemes.id
                INNER JOIN games_lexemes ON lexemes.id = games_lexemes.lexeme_id
                SET learning = 1
                WHERE `user_id` = " . Auth::user()->id . " AND game_id = " . $gameID . ";";
                $result = DB::select($sqlQuery);

                $sqlQuery = "UPDATE games_users SET learning = 1 WHERE `user_id` = " . $userID . " AND game_id = " . $gameID . ";";
                $result = DB::select($sqlQuery);
                // while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                //     $sqlQuery = "INSERT INTO user_lexeme(`user_id`, lexeme_id) VALUES((SELECT `user_id` FROM user WHERE `name` = '" . $name . "'), " . $row["lexeme_id"] . ");";
                //     $loopResult = mysqli_query($link, $sqlQuery);
                // }
            } catch (Exception $exceptionError) {
                echo $exceptionError->getMessage();
            }

        // $sqlQuery = "UPDATE user_lexeme SET learning = 1 WHERE `user_id` = " . $userID . " AND lexeme_id = " . $lexemeID . ";";

    }

    public function destroy() {
        
        $gameID = $_POST['gameID'];

        error_reporting(E_ERROR);
        try {
            include "../LinkpassAccess/linkpass.php";
            mysqli_select_db($link, "mroberts18_1");
            mysqli_set_charset($link, "utf8");

            $sqlQuery = "UPDATE lexemes_users
            INNER JOIN lexemes ON lexemes_users.lexeme_id = lexemes.id
            INNER JOIN games_lexemes ON lexemes.id = games_lexemes.lexeme_id
            SET lexemes_users.learning = 0
            WHERE `user_id` = " . Auth::user()->id . " AND game_id = " . $gameID . " AND lexemes.id NOT IN (
            SELECT DISTINCT lexemes.id
            FROM lexemes
            INNER JOIN games_lexemes ON lexemes.id = games_lexemes.lexeme_id
            INNER JOIN games ON games_lexemes.game_id = games.id
            INNER JOIN games_users ON games.id = games_users.game_id
            WHERE games_users.user_id = " . Auth::user()->id . " AND games.id != " . $gameID . " AND games_users.learning = 1
            );";

            $result = DB::select($sqlQuery);

            $sqlQuery = "UPDATE games_users SET learning = 0 WHERE `user_id` = " . Auth::user()->id . " AND game_id = " . $gameID . ";";
            
            $result = DB::select($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    
    }
}

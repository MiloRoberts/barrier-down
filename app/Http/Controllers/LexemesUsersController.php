<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class LexemesUsersController extends Controller {

    public function store() {

    $lexemeID = $_POST['lexemeID'];

    error_reporting(E_ERROR);

    try {
        $sqlQuery = "UPDATE lexemes_users SET learning = 1 WHERE `user_id` = " . Auth::user()->id . " AND lexeme_id = " . $lexemeID . ";";
        $result = DB::select($sqlQuery);
        // while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        //     $sqlQuery = "INSERT INTO user_lexeme(`user_id`, lexeme_id) VALUES((SELECT `user_id` FROM user WHERE `name` = '" . $name . "'), " . $row["lexeme_id"] . ");";
        //     $loopResult = mysqli_query($link, $sqlQuery);
        // }
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    public function destroy() {
        
        $lexemeID = $_POST['lexemeID'];

        error_reporting(E_ERROR);
        try {

            $sqlQuery = "UPDATE lexemes_users SET learning = 0 WHERE `user_id` = " . Auth::user()->id . " AND lexeme_id = " . $lexemeID . ";";
            
            $result = DB::select($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    public function toggle() {

        $gameID = $_POST['gameID'];
        $lexemeID = $_POST['lexemeID'];

        error_reporting(E_ERROR);
        try {

            $sqlQuery = "SELECT DISTINCT lexemes_users.learning
            FROM lexemes_users
            INNER JOIN lexemes ON lexemes_users.lexeme_id = lexemes.id
            INNER JOIN games_lexemes ON lexemes.id = games_lexemes.lexeme_id
            WHERE `user_id` = " . Auth::user()->id . " AND lexemes.id = " . $lexemeID . " AND games_lexemes.game_id = " . $gameID . ";";

            $result = DB::select($sqlQuery);

            // $dataToSend = $result;

            $dataToSend = "";

            foreach($result as $row) {  
                $dataToSend .= $row->learning;
            }

        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
        echo $dataToSend;
    }

}

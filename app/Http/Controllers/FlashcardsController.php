<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class FlashcardsController extends Controller
{
        public function show() {
        error_reporting(E_ERROR);

        try {

            $gamesList = $_POST['gamesList'];
            
            $sqlQuery = "SELECT DISTINCT lexemes.id, item, meaning, reading FROM lexemes INNER JOIN lexeme_items ON lexemes.lexeme_item_id = lexeme_items.id INNER JOIN lexemes_users ON lexemes.id = lexemes_users.lexeme_id INNER JOIN lexeme_meanings ON lexemes.lexeme_meaning_id = lexeme_meanings.id INNER JOIN lexeme_readings ON lexemes.lexeme_reading_id = lexeme_readings.id INNER JOIN games_lexemes ON lexemes.id = games_lexemes.lexeme_id INNER JOIN games ON games_lexemes.game_id = games.id INNER JOIN games_users ON games.id = games_users.game_id WHERE lexemes_users.user_id = '" . Auth::user()->id . "' AND lexemes_users.learning = 1 AND games_users.learning = 1 AND games_users.game_id IN(" . $gamesList . ") ORDER BY lexemes.id;";

            $result = DB::select($sqlQuery);

            $flashcardsArray = array();

            foreach($result as $row) {      
                $tempArray = array("lexemeID"=>$row->id, "item"=>$row->item, "meaning"=>$row->meaning,"reading"=>$row->reading, "classes"=>"", );

                array_push($flashcardsArray, $tempArray);
            }

            $sqlQuery = "SELECT DISTINCT lexemes.id, lexical_classes.class FROM lexemes INNER JOIN lexemes_lexical_classes ON lexemes.id = lexemes_lexical_classes.lexeme_id INNER JOIN lexical_classes ON lexemes_lexical_classes.lexical_class_id = lexical_classes.id INNER JOIN lexemes_users ON lexemes.id = lexemes_users.lexeme_id INNER JOIN games_lexemes ON lexemes.id = games_lexemes.lexeme_id INNER JOIN games ON games_lexemes.game_id = games.id INNER JOIN games_users ON games.id = games_users.game_id WHERE games_users.user_id = '" . Auth::user()->id . "' AND lexemes_users.learning = 1 AND games_users.learning = 1 AND games_users.game_id IN(" . $gamesList . ") ORDER BY lexemes.id;";

            $result = DB::select($sqlQuery);

            $idsArray = array();

            foreach($result as $row) {
                for ($i = 0; $i < count($flashcardsArray); $i++) {

                    if (strval($row["lexeme_id"]) == strval($flashcardsArray[$i]["lexemeID"])) {

                        if (array_search($row["lexeme_id"], $idsArray, false)) {
                            $flashcardsArray[$i]["classes"] .= "; " . $row["class"];
                        } else {

                            $flashcardsArray[$i]["classes"] = $row["class"];
                            array_push($idsArray, $row["lexeme_id"]);
                        }
                    }
                }
            }

            $dataToSend = json_encode($flashcardsArray);

        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
        echo $dataToSend;

        }
}

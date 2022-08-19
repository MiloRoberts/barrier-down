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
        $sqlQuery = "UPDATE lexemes_users SET learning = 1 WHERE `user_id` = " . $userID . " AND lexeme_id = " . $lexemeID . ";";
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

}

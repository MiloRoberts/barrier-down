<?php

namespace App\Http\Controllers;

// get Spout library for reading spreadsheets
// require_once './spout-3.3.0/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use DB;
use Illuminate\Http\Request;

class SpreadsheetsController extends Controller
{
    public function create() {

        return view('spreadsheet.create');
    }

    public function store() {
        // request()->validate([
        //     // TO DO
        // ]);

        if ($_FILES ['fileIn']['error'] > 0) {
            echo 'ERROR: ';
            switch ($_FILES ['fileIn']['error']) {
                case 1:
                    echo 'File Exceeds upload_max_filesize';
                    break;
                case 2:
                    echo 'File Exceeds max_file_size';
                    break;
                case 3:
                    echo 'Incomplete File Upload';
                    break;
                case 4:
                    echo 'No File Uploaded';
                    break;
                case 6:
                    echo 'Temp Directory Not Specified';
                    break;
                case 8:
                    echo 'PHP Extension Blocked File Upload';
                    break;
            }
            exit;
        }

        if ($_FILES ['fileIn']['type'] != 'application/vnd.oasis.opendocument.spreadsheet') {
            echo 'ERROR: Invalid Filetype';
            exit;
        }

        // get filepath
        // $filePath = '../../storage/' . basename($_FILES['fileIn']['name']);
        $filePath = storage_path('testingData.ods');
        // ddd($filePath);
        // upload the file to the server
        // TO DO: add this back in! Is the path correct? (See old version.)
        // move_uploaded_file($_FILES['fileIn']['tmp_name'], $filePath);

        // create reader and open file for reading
        $reader = ReaderEntityFactory::createReaderFromFile($filePath);
        $reader->open($filePath);

        // // TO DO: ALTER THIS SO THAT THE USER CAN SELECT A FILE FROM HIS/HER FILE SYSTEM!
        // $filePath = './documents/testingData.ods';
        // $reader = ReaderEntityFactory::createReaderFromFile($filePath);

        // // open file
        // $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCells();

                // create variables from spreedsheet row
                // addslashes to allow single quotes
                $englishTitleCell = trim(addslashes($cells[0]));
                $japaneseTitleCell = trim(addslashes($cells[1]));
                $gameConsoleCell = trim(addslashes($cells[2]));

                // create slugs
                $englishTitleSlug = str_replace(" ","-", strtolower($englishTitleCell));
                $gameConsoleSlug = str_replace(" ","-", strtolower($gameConsoleCell));
                $gameSlug = $englishTitleSlug . "-" . $gameConsoleSlug;

                $lexemeItemCell = trim(addslashes($cells[3]));
                $lexemeMeaningCell = trim(addslashes($cells[4]));
                $lexemeReadingCell = trim(addslashes($cells[5]));
                if ($lexemeReadingCell == "") {
                    $lexemeReadingCell = NULL;
                }
                $classesCell = trim(addslashes($cells[6]));
                $kanjiCharacterCell = trim(addslashes($cells[7]));
                $kanjiMeaningCell = trim(addslashes($cells[8]));
                $kanjiReadingCell = trim(addslashes($cells[9]));
                $kanjiReferenceCell = trim(addslashes($cells[10]));

                // begin inserting data into database
                DB::beginTransaction();

                $this->insertGameTitle($englishTitleCell, $japaneseTitleCell);
                $this->insertGameConsole($gameConsoleCell, $gameConsoleSlug);
                $this->insertGame($englishTitleCell, $japaneseTitleCell, $gameConsoleCell, $gameSlug);
                $this->insertGameUser();
                $this->insertData("lexeme_items", "item", $lexemeItemCell);
                $this->insertData("lexeme_meanings", "meaning", $lexemeMeaningCell);
                if ($lexemeReadingCell != NULL) {
                    $this->insertData("lexeme_readings", "reading", $lexemeReadingCell);
                }
                $this->insertLexeme($lexemeItemCell, $lexemeMeaningCell, $lexemeReadingCell);
                $this->insertGameLexeme($englishTitleCell, $japaneseTitleCell, $gameConsoleCell, $lexemeItemCell, $lexemeMeaningCell, $lexemeReadingCell);
                $this->insertLexemeUser();
                if ($kanjiCharacterCell != "") {
                    $this->insertKanjiCharacter($kanjiCharacterCell, $kanjiReferenceCell);
                }
                if ($kanjiMeaningCell != "") {
                    $this->insertData("kanji_meanings", "meaning", $kanjiMeaningCell);
                }
                if ($kanjiReadingCell != "") {
                    $this->insertData("kanji_readings", "reading", $kanjiReadingCell);
                }
                $this->insertKanji($kanjiReferenceCell, $kanjiMeaningCell, $kanjiReadingCell);
                $this->insertKanjiLexeme($kanjiReferenceCell, $kanjiMeaningCell, $kanjiReadingCell, $lexemeItemCell, $lexemeMeaningCell, $lexemeReadingCell);
                
                // deal with multiple lexical classes in single spreadsheet cell 
                $classesArray = [];
                $currentPosition = 0;
                $delimiterPosition = 0;
                $extractedClass = "";
                $numberOfClasses = substr_count($classesCell, ';')+1;

                while ($numberOfClasses > 1) {
                    $delimiterPosition = strpos($classesCell, ';', $currentPosition);
                    $extractedClass = trim(substr($classesCell, $currentPosition, $delimiterPosition - $currentPosition));
                    array_push($classesArray, $extractedClass);
                    $currentPosition = $delimiterPosition + 1;
                    $numberOfClasses--;
                }

                $extractedClass = trim(substr($classesCell, $currentPosition));
                array_push($classesArray, $extractedClass);
                foreach ($classesArray as $element) {
                    $this->insertData("lexical_classes", "class", $element);
                }
                foreach ($classesArray as $element) {
                    $this->insertLexemeLexicalClass($element, $lexemeItemCell, $lexemeMeaningCell, $lexemeReadingCell);
                }

                // Where and how do I use DB::rollBack(); with errors?

                DB::commit();
            }
        }

        return redirect('/')->with('success', 'Data Uploaded');

        
    }

// ========== FUNCTIONS ==========

    // TO DO: THESE NEED TO GIVE FEEDBACK TO THE USER FOR CONFIRMATION OF DATA INSERTIONS

    // ==================NO FIXED NEEDED!====================
    private function insertData($tableName, $fieldName, $dataContent){
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $sqlQuery = "INSERT IGNORE INTO " . $tableName ."(" . $fieldName .") VALUES('" . $dataContent ."');";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // =====================FIXED!===========================
    private function insertKanjiCharacter($character, $reference){
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $sqlQuery = "INSERT IGNORE INTO kanji_characters(`character`, reference) VALUES('" . $character ."', '" . $reference ."');";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // ====================NEWLY CREATED!=====================
    private function insertGameConsole($console, $game_console_slug){
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $sqlQuery = "INSERT IGNORE INTO game_consoles(console, slug) VALUES('" . $console ."', '" . $game_console_slug ."');";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // =====================FIXED!===========================
    private function insertGame($english_title, $japanese_title, $console, $game_slug) {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $sqlQuery = "INSERT IGNORE INTO games(game_title_id, game_console_id, slug) VALUES((SELECT id FROM game_titles WHERE english_title = '$english_title' AND japanese_title = '$japanese_title'), (SELECT id FROM game_consoles WHERE console = '$console'), '$game_slug');";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // =====================FIXED!===========================
    private function insertKanji($reference, $meaning, $reading) {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $sqlQuery = "INSERT IGNORE INTO kanji(kanji_character_id, kanji_meaning_id, kanji_reading_id) VALUES((SELECT id FROM kanji_characters WHERE reference = '" . $reference . "'), (SELECT id FROM kanji_meanings WHERE meaning = '" . $meaning . "'), (SELECT id FROM kanji_readings WHERE reading = '" . $reading . "'));";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // =====================FIXED!===========================
    private function insertLexeme($lexeme_item, $lexeme_meaning, $lexeme_reading) {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $existanceFlag = "";
            if (is_null($lexeme_reading)) {
                $existanceFlag = $this->verifyLexemeExists($lexeme_item, $lexeme_meaning);
                // echo $existanceFlag . " " . $lexeme_item . " " . $lexeme_meaning . "<br>";
                if ($existanceFlag == "1" || $existanceFlag == 1) {
                    return;   
                }
            }
            $sqlQuery = "INSERT IGNORE INTO lexemes(lexeme_item_id, lexeme_meaning_id, lexeme_reading_id) VALUES((SELECT id FROM lexeme_items WHERE item = '" . $lexeme_item . "'), (SELECT id FROM lexeme_meanings WHERE meaning = '" . $lexeme_meaning . "'), (SELECT id FROM lexeme_readings WHERE reading = '" . $lexeme_reading . "'));";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // ======================================================
    //         FIXED BUT DOESN'T CHECK ON A UNIQUE ROW !
    // ======================================================
    private function verifyLexemeExists($lexeme_item, $lexeme_meaning) {
        error_reporting(E_ERROR);
        try {
            $dataToSend = 0;
            // mysqli_set_charset($link, "utf8");

            $sqlQuery = "SELECT EXISTS (SELECT DISTINCT lexemes.id 
            FROM lexemes 
            INNER JOIN lexeme_items ON lexemes.id = lexeme_items.id 
            INNER JOIN lexeme_meanings ON lexemes.id = lexeme_meanings.id
            WHERE lexeme_items.item = '$lexeme_item' AND lexeme_meanings.meaning = '$lexeme_meaning')AS existance;";

            // var_dump($result);

            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);

            // var_dump($result);
            // if ($result->num_rows > 0) {
            //     $dataToSend = 1;
            // }

            // if(mysqli_num_rows($result) > 0){
            //     $dataToSend = 1;
            // }

            // if ($result) {
            // $row = mysqli_num_rows($result);
            //    if ($row)
            //       {
            //          printf("Number of row in the table : " . $row);
            //       }
            // // close the result.
            // mysqli_free_result($result);
            // }

            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                // var_dump($row);
                $dataToSend = $row['existance'];
                // if ($row['lexeme_id'] > 0) {
                //     $dataToSend = 1;
                // }
            }
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
        // return $row;
            return $dataToSend;
            // return $result;
            // if ($result) {
            //     return 1;
            // } else {
            //     return 0;
            // }
    }

    // ==============================================
    // THIS IS ALLOWING DUPLICATES ENTRIES!
    // ==============================================
    private function insertLexemeLexicalClass($lexical_class, $lexeme_item, $lexeme_meaning, $lexeme_reading) {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");

            if (is_null($lexemeReadingCell)) {
                $sqlQuery = "INSERT IGNORE INTO lexemes_lexical_classes(lexical_class_id, lexeme_id) VALUES((SELECT lexical_classes.id FROM lexical_classes WHERE class = '" . $lexical_class . "'), (SELECT lexemes.id FROM lexemes
                INNER JOIN lexeme_items ON lexemes.lexeme_item_id = lexeme_items.id 
                INNER JOIN lexeme_meanings ON lexemes.lexeme_meaning_id = lexeme_meanings.id 
                WHERE lexeme_items.item = '" . $lexeme_item . "' AND lexeme_meanings.meaning = '" . $lexeme_meaning . "'));";
            } else {   
                $sqlQuery = "INSERT IGNORE INTO lexemes_lexical_classes(lexical_class_id, lexeme_id) VALUES((SELECT lexical_classes.id FROM lexical_classes WHERE class = '" . $lexical_class . "'), (SELECT lexemes.id 
                FROM lexemes 
                INNER JOIN lexeme_items ON lexemes.lexeme_item_id = lexeme_items.id 
                INNER JOIN lexeme_meanings ON lexemes.lexeme_meaning_id = lexeme_meanings.id 
                INNER JOIN lexeme_readings ON lexemes.lexeme_reading_id = lexeme_readings.id 
                WHERE lexeme_items.item = '" . $lexeme_item . "' AND lexeme_meanings.meaning = '" . $lexeme_meaning . "' AND lexeme_readings.reading = '" . $lexeme_reading . "'));";
            }

            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // ======================== FIXED! ============================
    private function insertGameUser() {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $sqlQuery = "SELECT users.id, game_title_id, game_console_id FROM users, games;";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $sqlQuery = "INSERT IGNORE INTO games_users(`user_id`, game_id) VALUES('" . $row["id"] . "',(SELECT games.id FROM games WHERE game_title_id = '" . $row["game_title_id"] . "' AND game_console_id = '" . $row["game_console_id"] . "'));";
                // $loopResult = mysqli_query($link, $sqlQuery);
                $loopResult = DB::statement($sqlQuery);
            }
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // ============================================================
    //           WORKS BUT, YET AGAIN, ALLOWS DUPLICATES!
    // ============================================================
    private function insertKanjiLexeme($reference, $kanji_meaning, $kanji_reading, $lexeme_item, $lexeme_meaning, $lexeme_reading) {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            
            $sqlQuery = "INSERT IGNORE INTO kanji_lexemes(kanji_id, lexeme_id) VALUES((SELECT kanji.id FROM kanji
            INNER JOIN kanji_characters ON kanji.kanji_character_id = kanji_characters.id
            INNER JOIN kanji_meanings ON kanji.kanji_meaning_id = kanji_meanings.id
            INNER JOIN kanji_readings ON kanji.kanji_reading_id = kanji_readings.id
            WHERE kanji_characters.reference = '" . $reference . "' AND kanji_meanings.meaning = '" . $kanji_meaning . "' AND kanji_readings.reading = '" . $kanji_reading . "'), (SELECT lexemes.id 
            FROM lexemes 
            INNER JOIN lexeme_items ON lexemes.lexeme_item_id = lexeme_items.id 
            INNER JOIN lexeme_meanings ON lexemes.lexeme_meaning_id = lexeme_meanings.id 
            INNER JOIN lexeme_readings ON lexemes.lexeme_reading_id = lexeme_readings.id 
            WHERE lexeme_items.item = '" . $lexeme_item . "' AND lexeme_meanings.meaning = '" . $lexeme_meaning . "' AND lexeme_readings.reading = '" . $lexeme_reading . "'));";

            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);

        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // ===========================================================
    // FIXED BUT EACH CAN ALLOW DUPLICATE VALUES!
    // ===========================================================
    private function insertGameLexeme($english_title, $japanese_title, $game_console, $lexeme_item, $lexeme_meaning, $lexeme_reading) {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            if (is_null($lexemeReadingCell)) {                        
                $sqlQuery = "INSERT IGNORE INTO games_lexemes(game_id, lexeme_id) VALUES((SELECT games.id 
                FROM games
                INNER JOIN game_titles ON games.game_title_id = game_titles.id 
                INNER JOIN game_consoles ON games.game_console_id = game_consoles.id 
                WHERE game_titles.english_title = '" . $english_title . "' AND game_titles.japanese_title = '" . $japanese_title . "' AND game_consoles.console = '" . $game_console . "'), (SELECT lexemes.id FROM lexemes
                INNER JOIN lexeme_items ON lexemes.lexeme_item_id = lexeme_items.id 
                INNER JOIN lexeme_meanings ON lexemes.lexeme_meaning_id = lexeme_meanings.id 
                WHERE lexeme_items.item = '" . $lexeme_item . "' AND lexeme_meanings.meaning = '" . $lexeme_meaning . "'));";
            } else {
                $sqlQuery = "INSERT IGNORE INTO games_lexemes(game_id, lexeme_id) VALUES((SELECT games.id 
                FROM games
                INNER JOIN game_titles ON games.game_title_id = game_titles.id 
                INNER JOIN game_consoles ON games.game_console_id = game_consoles.id 
                WHERE game_titles.english_title = '" . $english_title . "' AND game_titles.japanese_title = '" . $japanese_title . "' AND game_consoles.console = '" . $game_console . "'), (SELECT lexemes.id 
                FROM lexemes 
                INNER JOIN lexeme_items ON lexemes.lexeme_item_id = lexeme_items.id 
                INNER JOIN lexeme_meanings ON lexemes.lexeme_meaning_id = lexeme_meanings.id 
                INNER JOIN lexeme_readings ON lexemes.lexeme_reading_id = lexeme_readings.id 
                WHERE lexeme_items.item = '" . $lexeme_item . "' AND lexeme_meanings.meaning = '" . $lexeme_meaning . "' AND lexeme_readings.reading = '" . $lexeme_reading . "'));";
            }

            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);

        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // ====================================================
    //        SAME PROBLEM WITH DUPLICATES!
    // ====================================================
    private function insertLexemeUser() {
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            if (is_null($lexemeReadingCell)) {
                $sqlQuery = "SELECT users.id, lexeme_item_id, lexeme_meaning_id FROM users, lexemes;";
                // $result = mysqli_query($link, $sqlQuery);
                $result = DB::statement($sqlQuery);
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $sqlQuery = "INSERT IGNORE INTO lexemes_users(`user_id`, lexeme_id) VALUES('" . $row["id"] . "',(SELECT lexemes.id FROM lexemes WHERE lexeme_item_id = '" . $row["lexeme_item_id"] . "' AND lexeme_meaning_id = '" . $row["lexeme_meaning_id"] . "'));";
                // $loopResult = mysqli_query($link, $sqlQuery);
                $loopResult = DB::statement($sqlQuery);
            }
            } else {
                $sqlQuery = "SELECT users.id, lexeme_item_id, lexeme_meaning_id, lexeme_reading_id FROM users, lexemes;";
                // $result = mysqli_query($link, $sqlQuery);
                $result = DB::statement($sqlQuery);
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $sqlQuery = "INSERT IGNORE INTO lexemes_users(`user_id`, lexeme_id) VALUES('" . $row["id"] . "',(SELECT lexemes.id FROM lexemes WHERE lexeme_item_id = '" . $row["lexeme_item_id"] . "' AND lexeme_meaning_id = '" . $row["lexeme_meaning_id"] . "' AND lexeme_reading_id = '" . $row["lexeme_reading_id"] . "'));";
                    // $loopResult = mysqli_query($link, $sqlQuery);
                    $loopResult = DB::statement($sqlQuery);
                }
            }

        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // =====================FIXED!===========================
    private function insertGameTitle($english_title, $japanese_title){
        error_reporting(E_ERROR);
        try {
            // mysqli_set_charset($link, "utf8");
            $sqlQuery = "INSERT IGNORE INTO game_titles(english_title, japanese_title) VALUES('" . $english_title ."', '" . $japanese_title ."');";
            // $result = mysqli_query($link, $sqlQuery);
            $result = DB::statement($sqlQuery);
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

}

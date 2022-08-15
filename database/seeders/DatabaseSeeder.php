<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameConsole;
use App\Models\GameTitle;
use App\Models\KanjiCharacter;
use App\Models\KanjiMeaning;
use App\Models\KanjiReading;
use App\Models\LexemeItem;
use App\Models\LexemeMeaning;
use App\Models\LexemeReading;
use App\Models\LexicalClass;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // clears tables of data to allow reseeding without remigrating
        // seems that all tables must be truncated for this to work
        // Game::truncate();
        // GameTitle::truncate();
        // GameConsole::truncate();

        $sony_playstation = GameConsole::create([
            'console' => 'Sony Playstation',
            'slug' => 'sony-playstation'
        ]);

        $nintendo_super_famicom = GameConsole::create([
            'console' => 'Nintendo Super Famicom',
            'slug' => 'nintendo-super-famicom'
        ]);

        $culdcept_expansion_plus = GameTitle::create([
            'english_title' => 'Culdcept Expansion Plus',
            'japanese_title' => 'カルドセプト エキスパンション・プラス'
        ]);

        $super_puyo_puyo_tsuu_remix = GameTitle::create([
            'english_title' => 'Super Puyo Puyo Tsuu Remix',
            'japanese_title' => 'すーぱーぷよぷよ通リミックス'
        ]);

        Game::create([
            'game_console_id' => $sony_playstation->id,
            'game_title_id' => $culdcept_expansion_plus->id,
            // maybe get a slug from a method instead
            'slug' => 'culdcept-expansion-plus-sony-playstation',
            'info' => '<h4>Some Heading</h4><p>Culdcept yadda yadda yadda...</p>'
        ]);

        Game::create([
            'game_console_id' => $nintendo_super_famicom->id,
            'game_title_id' => $super_puyo_puyo_tsuu_remix->id,
            // maybe get a slug from a method instead
            'slug' => 'super-puyo-puyo-tsuu-remix-super-famicom',
            'info' => '<h4>Some Heading</h4><p>Puyo Puyo yadda yadda yadda...</p>'
        ]);

        LexicalClass::create([
            'class' => 'noun'
        ]);

        LexemeItem::create([
            'item' => '日本'
        ]);

        LexemeMeaning::create([
            'meaning' => 'Japan'
        ]);

        LexemeReading::create([
            'reading' => 'ほん'
        ]);

        KanjiCharacter::create([
            'character' => '日',
            'reference' => 'a12.b3'
        ]);

        KanjiMeaning::create([
            'meaning' => 'day'
        ]);

        KanjiReading::create([
            'reading' => '二'
        ]);
    }
}

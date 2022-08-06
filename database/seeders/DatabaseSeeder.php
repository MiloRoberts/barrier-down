<?php

namespace Database\Seeders;

use App\Models\ConsoleManufacturer;
use App\Models\ConsoleName;
use App\Models\Game;
use App\Models\GameConsole;
use App\Models\GameTitle;
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
        // ConsoleManufacturer::truncate();
        // ConsoleName::truncate();

        $sony = ConsoleManufacturer::create([
            'manufacturer' => 'Sony'
        ]);

        $nintendo = ConsoleManufacturer::create([
            'manufacturer' => 'Nintendo'
        ]);

        $sega = ConsoleManufacturer::create([
            'manufacturer' => 'Sega'
        ]);

        $playstation = ConsoleName::create([
            'name' => 'Playstation'
        ]);

        $super_famicom = ConsoleName::create([
            'name' => 'Super Famicom'
        ]);

        $saturn = ConsoleName::create([
            'name' => 'Saturn'
        ]);

        $sony_playstation = GameConsole::create([
            'console_manufacturer_id' => $sony->id,
            'console_name_id' => $playstation->id,
            'slug' => 'sony-playstation'
        ]);

        $nintendo_super_famicom = GameConsole::create([
            'console_manufacturer_id' => $nintendo->id,
            'console_name_id' => $super_famicom->id,
            'slug' => 'nintendo-super-famicom'
        ]);

        $sega_saturn = GameConsole::create([
            'console_manufacturer_id' => $sega->id,
            'console_name_id' => $saturn->id,
            'slug' => 'sega-saturn'
        ]);

        $culdcept_expansion_plus = GameTitle::create([
            'english_title' => 'Culdcept Expansion Plus',
            'japanese_title' => 'カルドセプト エキスパンション・プラス'
        ]);

        $super_puyo_puyo_tsuu_remix = GameTitle::create([
            'english_title' => 'Super Puyo Puyo Tsuu Remix',
            'japanese_title' => 'すーぱーぷよぷよ通リミックス'
        ]);

        $culdcept = GameTitle::create([
            'english_title' => 'Culdcept',
            'japanese_title' => 'カルドセプト'
        ]);

        $psychic_force_2 = GameTitle::create([
            'english_title' => 'Psychic Force 2',
            'japanese_title' => 'サイキックフォース2'
        ]);

        Game::create([
            'game_console_id' => $sony_playstation->id,
            'game_title_id' => $culdcept_expansion_plus->id,
            // maybe get a slug from a method instead
            'slug' => 'culdcept-expansion-plus-sony-playstation'
        ]);

        Game::create([
            'game_console_id' => $nintendo_super_famicom->id,
            'game_title_id' => $super_puyo_puyo_tsuu_remix->id,
            // maybe get a slug from a method instead
            'slug' => 'super-puyo-puyo-tsuu-remix-super-nintendo'
        ]);

        Game::create([
            'game_console_id' => $sega_saturn->id,
            'game_title_id' => $culdcept->id,
            // maybe get a slug from a method instead
            'slug' => 'culdcept-sega-saturn'
        ]);

        Game::create([
            'game_console_id' => $sony_playstation->id,
            'game_title_id' => $psychic_force_2->id,
            // maybe get a slug from a method instead
            'slug' => 'psychic-force-2-sony-playstation'
        ]);
    }
}

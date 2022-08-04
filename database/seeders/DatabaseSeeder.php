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

        ConsoleManufacturer::create([
            'manufacturer' => 'Sony'
        ]);

        ConsoleManufacturer::create([
            'manufacturer' => 'Nintendo'
        ]);

        ConsoleName::create([
            'name' => 'Playstation'
        ]);

        ConsoleName::create([
            'name' => 'Super Famicom'
        ]);

        GameConsole::create([
            'console_manufacturer_id' => 1,
            'console_name_id' => 1
        ]);

        GameConsole::create([
            'console_manufacturer_id' => 2,
            'console_name_id' => 2
        ]);

        GameTitle::create([
            'english_title' => 'Culdcept Expansion Plus',
            'japanese_title' => 'カルドセプト エキスパンション・プラス'
        ]);

        GameTitle::create([
            'english_title' => 'Super Puyo Puyo Tsuu Remix',
            'japanese_title' => 'すーぱーぷよぷよ通リミックス'
        ]);

        Game::create([
            'game_console_id' => 1,
            'game_title_id' => 1
        ]);

        Game::create([
            'game_console_id' => 2,
            'game_title_id' => 2
        ]);
    }
}

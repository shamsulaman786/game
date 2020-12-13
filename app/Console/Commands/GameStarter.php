<?php

namespace App\Console\Commands;
use App\Console\Game;

use Illuminate\Console\Command;

class GameStarter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command start the game';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $game = new Game();
        $result = $game->prepareGame();
        echo "$result\n";
    }
}

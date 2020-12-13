<?php

namespace Tests\Unit;

use App\Console\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * A basic unit test for losing team A
     * Assigned valus to team A are comparatively lesser than B.
     *
     * @return void
     */
    public function testGame()
    {
        $result=false;
        $strengthTeamA = [35, 10, 30, 20, 90];
        $strengthTeamB = [30, 100, 20, 50, 40];
        $game = new Game($strengthTeamA,$strengthTeamB);
        $result = $game->prepareGame();

        $this->assertEquals($result,'Lose');
    }
}

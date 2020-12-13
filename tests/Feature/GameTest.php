<?php

namespace Tests\Feature;

use App\Console\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameTest extends TestCase
{
    /**
     * A basic feature test for game.
     * Two assertions are there one for winning & other for losing team A
     *
     * @return void
     */
    public function testGame()
    {
        $noOfPlayers = 5;
        $this->teamAWinnigTest($noOfPlayers);
        $this->teamALosingTest($noOfPlayers);
    }

    /**
     * Team A winning assertion
     * 
     * @param int no of players for gaming.
     * 
     * @return void 
     */
    public function teamAWinnigTest($noOfPlayers)
    {
        while ($noOfPlayers>0) {
            $minStrength = rand(1,90);
            $strengthTeamA[] = rand($minStrength++,100);
            $strengthTeamB[] = $minStrength;
            $noOfPlayers--;
        }
        $game = new Game($strengthTeamA,$strengthTeamB);
        $result = $game->prepareGame();

        $this->assertEquals('Win',$result);

    }


    /**
     * Team A losing assertion
     * 
     * @param int no of players for gaming.
     * 
     * @return void 
     */
    public function teamALosingTest($noOfPlayers)
    {
        while ($noOfPlayers>0) {
            $minStrength = rand(1,90);
            $strengthTeamA[] = $minStrength;
            $strengthTeamB[] = rand($minStrength++,100);
            $noOfPlayers--;
        }
        $game = new Game($strengthTeamA,$strengthTeamB);
        $result = $game->prepareGame();

        $this->assertEquals('Lose',$result);

    }
}

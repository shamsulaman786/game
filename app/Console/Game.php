<?php
namespace App\Console;
use Illuminate\Support\Arr;

class Game 
{
    /**
     * The instance of current class.
     *
     * @var Game
     */
    private $game;

    /**
     * The collection of strength & fighting status of team A players.
     *
     * @var associative array
     */
    private $teamA = [];
    
    /**
     * The collection of strength & fighting status of team B players.
     *
     * @var associative array
     */
    private $teamB = [];

    /**
     * The collection of strength given by user for team A players.
     * 
     * @var int array
     */
    private $strengthTeamA = [];

    /**
     * The collection of strength given by user for team B players.
     * 
     * @var int array
     */
    private $strengthTeamB = [];

    /**
     * The no of innings of fighting
     * 
     * @var int
     */
    private $innings;

    /**
     * The final result of fighting b/w teams
     * 
     * @var string
     */
    private $result;

    /**
     * Initialize inning & result vars.
     *
     * @return game instance
     */
    public function __construct($strengthTeamA=[],$strengthTeamB=[])
    {
        $this->innings = 0;
        $this->result = true;
        $this->strengthTeamA = $strengthTeamA;
        $this->strengthTeamB = $strengthTeamB;
        return $this->game;
    }

    /**
     * @method define the strength of both teams by taking input from user
     * After preparation, game starts.
     *
     * @return string result of the game that comes after game starts
     */
    public function prepareGame()
    {
        if (empty($this->strengthTeamA)) {
            $this->strengthTeamA = explode(',',readline("Enter A Teams players:"));
        }
        if (empty($this->strengthTeamB)) {
            $this->strengthTeamB = explode(',',readline("Enter B Teams players:"));
        }
        $this->teamA = $this->getPreparedTeam($this->strengthTeamA,true);
        $this->teamB = $this->getPreparedTeam($this->strengthTeamB);

        return $this->startGame();
    }

    /**
     * @method game starts with fighting of players of both team one by one,
     * if any player of Team A loses , Team A loses immediatedly.
     * 
     * @return string result of the game.
     */
    private function startGame()
    {
        $teamA = $this->teamA;
        $teamB = $this->teamB;
        while ($this->innings < sizeof($teamA)) {
            $this->innings++;
            $fightingPlayerTeamB = $this->getFightingPlayerTeamB();
            $fightingPlayerTeamA = $this->getFightingPlayerTeamA($fightingPlayerTeamB['strength']);

            if ($fightingPlayerTeamB['strength']>=$fightingPlayerTeamA['strength']) {
                $this->result = false;
            break;
            }
        }
        return ($this->result==true) ? 'Win' : 'Lose' ;
    }

    /**
     * @method prepare the team by defining the fighting strength & status of all players.
     * 
     * @param array of strengths
     * @param boolean is the given team focus of the game.
     * 
     * @return array associated with strength & fighting status 0.
     */
    private function getPreparedTeam($teamStrength,$sort=false)
    {
        $team = [];
        $i = 0;
        if ($sort) {
            $teamStrength = Arr::sort($teamStrength);
        }else{
            shuffle($teamStrength);
        }

        foreach ($teamStrength as $playerStrength) {
            $team[$i]['strength']=intval($playerStrength);
            $team[$i]['hasFought']=0;
            $i++;
        }

        return $team;
    }

    /**
     * @method elects the fighting player for team b who didn't fight yet.
     * 
     * @return the eligible fighting player
     */
    private function getFightingPlayerTeamB()
    {
        $teamBPlayerIndex = $this->innings-1;
        $this->teamB[$teamBPlayerIndex]['hasFought']=1;
        $fightingPlayerTeamB = $this->teamB[$teamBPlayerIndex];

       return $fightingPlayerTeamB;
    }

    /**
     * @method elects the fighting player for team A who didn't fight yet
     *  and has better strength than opponent's strength.
     * if no player has better strength then returns the strongest player 
     * who didn't fight yet
     * 
     * @param strength of oppoenent to fighting
     * 
     * @return the stronger or best eligible fighting player
     */
    private function getFightingPlayerTeamA($opponentPlayersStrength)
    {
        foreach ($this->teamA as $playerA) {
            if ($playerA['hasFought']==0 && $playerA['strength']>$opponentPlayersStrength) {
                $playerA['hasFought']=1;
                $fightingPlayerTeamA = $playerA;
                return $fightingPlayerTeamA;
            }
        }

        for ($i=(sizeof($this->teamA)-1); $i >=0 ; $i--){ 
            if ($this->teamA[$i]['hasFought']==0) {
                $this->teamA[$i]['hasFought']=1;
                $fightingPlayerTeamA = $this->teamA[$i];
                return $fightingPlayerTeamA;
            }

        }

    }
}

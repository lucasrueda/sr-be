<?php

namespace Tests\Unit;

use App\Services\TournamentService;

use App\User;
use Tests\TestCase;

class PlayersIntegrityTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGoaliePlayersExist ()
    {
/*
		Check there are players that have can_play_goalie set as 1
*/
		$result = User::where('user_type', 'player')->where('can_play_goalie', 1)->count();
		$this->assertTrue($result > 1);

    }
    public function testAtLeastOneGoaliePlayerPerTeam ()
    {
/*
	    calculate how many teams can be made so that there is an even number of teams and they each have between 18-22 players.
	    Then check that there are at least as many players who can play goalie as there are teams
*/

        $tournamentService = $this->createApplication()->make(TournamentService::class);

        $goalies = collect([]);
        $players = User::query()
            ->ofPlayers()
            ->get();

        $players = $players->filter(function($player) use(&$goalies){
            if($player->is_goalie){
                $goalies->push($player);
                return false;
            }
            return true;
        });

        $numTeams = $tournamentService->getNumberOfTeams($players,$goalies);

        $this->assertTrue($goalies->count() >= $numTeams);

        $teams = $tournamentService->getTeams($players,$goalies,$numTeams);

        $this->assertTrue($numTeams % 2 == 0);

        foreach ($teams as $team){
            $this->assertThat(
                sizeof($team['players']),
                $this->logicalAnd(
                    $this->greaterThanOrEqual(18),
                    $this->lessThanOrEqual(22)
                )
            );
        }


    }
}

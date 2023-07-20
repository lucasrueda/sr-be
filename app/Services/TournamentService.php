<?php

namespace App\Services;

use Faker\Factory as Faker;

class TournamentService
{
    public function getNumberOfTeams($players,$goalies){
        $totalPlayers = $players->count() + $goalies->count();
        $teamSize = random_int(18,22);
        $numTeams = intdiv($totalPlayers,$teamSize);

        if($numTeams % 2 !== 0){
            if(intdiv($totalPlayers,$numTeams - 1) > 22){
                $numTeams++;
            }else{
                $numTeams--;
            }
        }
        return $numTeams;
    }

    public function getTeams($players,$goalies,$numTeams){
        $faker = Faker::create();

        $teams = collect(range(1,$numTeams))
            ->map(function($item) use ($faker,&$goalies){
                $newGoalie = $goalies->pop();
                return [
                    'name'=>$faker->words(3,true),
                    'players'=>collect([$newGoalie]),
                    'ranking'=>0
                ];
            })->toArray();

        $players = $players->concat($goalies)->sortByDesc('ranking');
        while (!$players->isEmpty()){
            usort($teams,function($t1,$t2){
                return $t1['ranking'] <=> $t2['ranking'];
            });
            $newPlayer = $players->pop();
            $teams[0]['players']->push($newPlayer);
            $teams[0]['ranking'] = $teams[0]['ranking'] + $newPlayer['ranking'];
        }
        return $teams;
    }

}

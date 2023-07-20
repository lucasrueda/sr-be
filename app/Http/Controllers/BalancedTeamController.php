<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class BalancedTeamController extends Controller
{
    public function index(Request $request){

        $faker = Faker::create();

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


        $totalPlayers = $players->count() + $goalies->count();
        $teamSize = random_int(18,22);
        $numTeams = intdiv($totalPlayers,$teamSize);

        if($numTeams % 2 !== 0){
            $numTeams--;
        }

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

        return view('balanced-teams',compact('teams'));
    }
}

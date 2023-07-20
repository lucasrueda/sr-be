<?php

namespace App\Http\Controllers;

use App\Services\TournamentService;
use App\User;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    private $tournamentService;

    public function __construct(TournamentService $tournamentService)
    {
        $this->tournamentService = $tournamentService;
    }

    public function index(Request $request)
    {

        $goalies = collect([]);
        $players = User::query()
            ->ofPlayers()
            ->get();

        $players = $players->filter(function ($player) use (&$goalies) {
            if ($player->is_goalie) {
                $goalies->push($player);
                return false;
            }
            return true;
        });

        $numTeams = $this->tournamentService->getNumberOfTeams($players, $goalies);
        $teams = $this->tournamentService->getTeams($players, $goalies, $numTeams);

        return view('tournament', compact('teams'));
    }
}

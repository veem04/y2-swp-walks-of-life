<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Journey;
use DB;

class LeaderboardController extends Controller
{
    public function index(){
        
        $twoWeeksAgo = strtotime('-2 weeks');
        $twoWeeksAgoStr = date('Y-m-d', $twoWeeksAgo);

        // god save me
        $users = DB::table('users')
                    ->join('journeys', 'users.id', '=', 'journeys.user_id')
                    ->groupBy('user_id')
                    ->selectRaw('`users`.*, SUM(`journeys`.`max_co2`) - SUM(`co2_emissions`) AS `co2_saved`')
                    ->where('date', '>', $twoWeeksAgoStr)
                    ->orderBy('co2_saved', 'desc')
                    ->paginate(8);
        // dd($users);

        return view('leaderboard.index', [
            'users' => $users
        ]);
    }
}

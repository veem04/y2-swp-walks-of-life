<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Journey;
use DB;

class LeaderboardController extends Controller
{
    public function index(){
        $users = User::orderBy('created_at', 'desc')->paginate(8);

        $twoWeeksAgo = strtotime('-2 weeks');
        $twoWeeksAgoStr = date('Y-m-d', $twoWeeksAgo);
        // dd($twoWeeksAgoStr);
        foreach ($users as $user) {
            $co2_values = DB::table('journeys')
                ->where('user_id', '=', $user->id)
                ->where('date', '>', $twoWeeksAgoStr)
                ->get();
            
            $total_saved = 0;
            foreach ($co2_values as $key => $val) {
                $total_saved += $val->max_co2 - $val->co2_emissions;
            }
            $user->total_saved = $total_saved;

            $users->sortBy('total_saved');
        }
        return view('leaderboard.index', [
            'users' => $users
        ]);
    }
}

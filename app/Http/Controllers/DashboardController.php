<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journey;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function dashboard(){
        $journeys = Auth::user()->journeys()->orderBy('created_at', 'desc')->take(3)->get();

        $twoWeeksAgo = strtotime('-2 weeks');
        $twoWeeksAgoStr = date('Y-m-d', $twoWeeksAgo);

        $saved_last_two_weeks = 
            Auth::user()->journeys()
            ->where('date', '>', $twoWeeksAgoStr)
            ->sum(DB::raw('max_co2 - co2_emissions'));
        // dd($saved_last_two_weeks);

        return view('dashboard', [
            'journeys' => $journeys,
            'saved_last_two_weeks' => $saved_last_two_weeks,
        ]);
    }
}

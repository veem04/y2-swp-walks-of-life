<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LeaderboardController extends Controller
{
    public function index(){
        $users = User::orderBy('created_at', 'desc')->paginate(8);
        return view('leaderboard.index', [
            'users' => $users
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Friendship extends Model
{
    use HasFactory;

    public static function findRequestOfAuth(string $id): ?Friendship {
        return Friendship::whereRaw('`user_id` = ' . Auth::user()->id . ' AND `friend_id` = ' . $id)
                ->orWhereRaw('`user_id` = ' . $id . ' AND `friend_id` = ' . Auth::user()->id)
                ->first();
    }
}

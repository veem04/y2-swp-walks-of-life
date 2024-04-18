<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Friendship;
use DB;

class FriendController extends Controller
{
    public function index(){
        $friendRequests = Auth::user()->friends()->orderBy('created_at', 'desc')->get();
        $friends = $friendRequests->filter(function ($value, int $key){
            return $value->pivot->accepted === 1;
        });
        
        $outgoingRequests = Auth::user()->pendingFriendsTo()->get();
        $incomingRequests = Auth::user()->pendingFriendsFrom()->get();

        return view('friends.index', [
            'friends' => $friends,
            'outgoingRequests' => $outgoingRequests,
            'incomingRequests' => $incomingRequests
        ]);
    }

    public function store(Request $request){
        // dd($request);
        $user = User::where('friend_code', '=', $request->fcode)->first();
        if($user === null)
        {
            return redirect()
                ->route('friends.index')
                ->with('status', 'That friend code does not exist.');
        }

        $existingOutgoing = Friendship::where('user_id', '=', Auth::user()->id)->where('friend_id', '=', $user->id)->first();
        if($existingOutgoing !== null){
            $statusMessage = $existingOutgoing->accepted 
                ? "You are already friends with that person." 
                : "You have already sent a friend request to that person.";

            return redirect()
                ->route('friends.index')
                ->with('status', $statusMessage);
        }
        
        $existingIncoming = Friendship::where('user_id', '=', $user->id)->where('friend_id', '=', Auth::user()->id)->first();
        if($existingIncoming !== null){
            $existingIncoming->accepted = 1;
            $existingIncoming->save();
            return redirect()
                ->route('friends.index')
                ->with('status', 'Friend added!');
        }
        

        $friendRequest = new Friendship;
        $friendRequest->user_id = Auth::user()->id;
        $friendRequest->friend_id = $user->id;
        $friendRequest->accepted = 0;
        $friendRequest->save();
        
        return redirect()
                ->route('friends.index')
                ->with('status', 'You have sent a friend request!');
    }

    public function update(String $id){
        $request = Friendship::findRequestOfAuth($id);
        if($request === null){
            return redirect()
                ->route('friends.index')
                ->with('status', 'There was an error finding the friend to add.');
        }
        $request->accepted = 1;
        $request->save();
        return redirect()
                ->route('friends.index')
                ->with('status', 'Friend successfully added!');
    }

    public function destroy(String $id){
        $request = Friendship::findRequestOfAuth($id);
        if($request === null)
        {
            return redirect()
                ->route('friends.index')
                ->with('status', 'There was an error finding the friend to remove.');
        }
        $request->delete();
        return redirect()
                ->route('friends.index')
                ->with('status', 'Friend successfully removed.');
    }
}

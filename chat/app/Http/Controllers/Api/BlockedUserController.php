<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class BlockedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_user = User::find($request->currentUser);
        $usersBlocked = BlockedUser::where('blocking_user_id', $current_user->id)->get();
        $users_blocked_container = [];

        foreach ($usersBlocked as $userBlocked) {
            $blockedUser = User::find($userBlocked->blocked_user_id);
            if ($blockedUser) {
                $users_blocked_container[] = [
                    'id' => $userBlocked->id,
                    'user_blocked' => $blockedUser
                ];
            }
        }
        return $users_blocked_container;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'blocking_user_id' => 'required',
            'blocked_user_id' => 'required'
        ]);

        BlockedUser::create([
            'blocking_user_id' => $request->blocking_user_id,
            'blocked_user_id' => $request->blocked_user_id
        ]);

        return ['success' => 'Utente creato con successo'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlockedUser  $blockedUser
     * @return \Illuminate\Http\Response
     */
    public function show(BlockedUser $blockedUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlockedUser  $blockedUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlockedUser $blockedUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlockedUser  $blockedUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlockedUser $blockedUser)
    {

        $user = BlockedUser::find($blockedUser->id);
        $user->delete();

        return ['success' =>  'Utente sbloccato con successo'];
    }
}

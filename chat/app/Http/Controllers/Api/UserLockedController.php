<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLocked;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class UserLockedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_user = User::find($request->currentUser);
        $usersBlocked = UserLocked::where('blocking_user_id', $current_user->id)->get();
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

        UserLocked::create([
            'blocking_user_id' => $request->blocking_user_id,
            'blocked_user_id' => $request->blocked_user_id
        ]);

        return ['success' => 'Utente creato con successo'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserLocked  $userLocked
     * @return \Illuminate\Http\Response
     */
    public function show(UserLocked $userLocked)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserLocked  $userLocked
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLocked $userLocked)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserLocked  $userLocked
     * @return \Illuminate\Http\Response
     */
    // public function destroy(UserLocked $userLocked, Request $request)
    // {

    //     $a = UserLocked::find($userLocked->id)->delete();
    //     // $user = UserLocked::findOrFail($userLocked->id);
    //     // $user->delete();

    //     return ['success' =>  $request->id];
    // }

    public function delete(Request $request)
    {
        $user = UserLocked::find($request->id);
        $user->delete();

        return ['success' =>  'Utente sbloccato con successo'];
    }
}

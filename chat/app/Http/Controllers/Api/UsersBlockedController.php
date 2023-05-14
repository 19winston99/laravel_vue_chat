<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserBlocked;
use App\Models\User;
use Illuminate\Http\Request;

class UsersBlockedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_User = User::find($request->currentUser);
        $users = $current_User->usersBlocked;
        $users_blocked_container = [];

        foreach ($users as $user) {
            $users_blocked_container[] = [
                'id' => $user->id,
                'user_blocked' => User::find($user->blocked_user_id)
            ];
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserBlocked  $userBlocked
     * @return \Illuminate\Http\Response
     */
    public function show(UserBlocked $userBlocked)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserBlocked  $userBlocked
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserBlocked $userBlocked)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserBlocked  $userBlocked
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserBlocked $userBlocked)
    {
        // $user_blocked = UserBlocked::find($userBlocked);
        // $user_blocked->delete();

        return ['success' => $userBlocked->id];
    }
}

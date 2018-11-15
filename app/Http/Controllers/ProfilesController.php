<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Activity;

class ProfilesController extends Controller
{
    
    const RECORDS_PER_PAGE = 10;

    /**
     * Show the user's profile.
     *
     * @param  User $user
     * @return \Response
     */
    public function show(User $user)
    {
        $page = request('page') ?? 1;

        $activities = Activity::feed($user, self::RECORDS_PER_PAGE);

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $activities[0],
            'pagination' => $activities[1],
        ]);
    }
}

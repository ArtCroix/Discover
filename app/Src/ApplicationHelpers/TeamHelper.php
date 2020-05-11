<?php

namespace App\Src\ApplicationHelpers;

use App\User;


class TeamHelper
{
    public static function bindUserToTeam($user_id, $team_id)
    {
        /*    User::find($user_id)->events()->syncWithoutDetaching([$submit->application->event_id => ["team_id" => $team_id, "submit_id" => $submit->id]]); */
        User::find($user_id)->teams()->sync([$user_id => ["team_id" => $team_id]]);
    }

    public static function unbindUserFromTeam($team_id, $user_id)
    {
        // dd(User::find($user_id)->teams()->get());
        User::find($user_id)->teams()->detach([$user_id => ["team_id" => $team_id]]);
    }
}

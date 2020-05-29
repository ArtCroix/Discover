<?php

namespace App\Src;

use App\User;
use App\Models\Team;
use App\Events\AutoUserRegistered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TeamHandler
{

    public static function bindUserToTeam($user_id, $team_id)
    {
        User::find($user_id)->teams()->sync([$user_id => ["team_id" => $team_id]]);
    }

    public static function unbindUserFromTeam($team_id, $user_id)
    {
        User::find($user_id)->teams()->detach([$user_id => ["team_id" => $team_id]]);
    }

    public static function deleteTeam($team_id)
    {
        Team::find($team_id)->submit->delete();
    }
}

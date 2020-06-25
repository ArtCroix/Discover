<?php

namespace App\Src\ApplicationHelpers;

use App\Models\Application\Submit;
use App\User;
use App\Events\AutoUserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHandlers\AfterSubmitHandlers\TeamHandlers\InsertTeam;

class CreateNewSubmitFromExistingOne
{
    public static function getSubmitForCopy($submit_id)
    {
        return Submit::where('id', $submit_id)->first()->load(['application.event.teams', 'answers']);
    }

    public static function bindUserToSubmit($submit_for_bind, $user_id)
    {
        $existed_submit = Submit::with('users')->where('application_id', $submit_for_bind->application_id)->whereHas('users', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        })->first();

        if (!$existed_submit) {
            $submit_for_bind->users()->syncWithoutDetaching([$user_id]);
        }
    }
}

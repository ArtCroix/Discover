<?php

namespace App\Src\ApplicationHelpers;

use App\Models\Application\Submit;
use App\User;
use App\Events\AutoUserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers\InsertTeam;

class CreateNewSubmitFromExistingOne
{
    protected $submit;

    protected static function createUser($email)
    {
        $password = Str::random(8);
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $email,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now()
            ]
        );

        event(new AutoUserRegistered($user, $password));
        return $user;
    }

    protected static function loginUser($email)
    {
        $user = User::where("email", $email)->first();

        if (!isset($user)) {
            $user = self::createUser($email);
        }

        \Auth::guard()->login($user);
        return $user;
    }

    public static function copySubmit($submit_id, $email)
    {
        $user = self::loginUser($email);

        $submit = Submit::with(['application.event', 'answers'])->where('id', $submit_id)->where("user_id", "<>", $user->id)->first();

        if (isset($submit)) {
            $submit = $submit->replicate();
            $submit->user_id = $user->id;
            $answers_array = [];
            try {
                \DB::transaction(function () use (&$answers_array, $submit) {

                    $new_submit = Submit::firstOrCreate(
                        ["user_id" => $submit->user_id],
                        [
                            "user_id" => $submit->user_id,
                            "application_id" => $submit->application_id,
                            "additional_data" => $submit->additional_data,
                        ]
                    );
                    if (count($new_submit->answers) === 0) {
                        foreach ($submit->answers as $answer) {
                            $answer_copy = $answer->replicate();
                            $answer_copy->submit_id = $submit->id;
                            array_push($answers_array, $answer_copy);
                        }
                        $new_submit->answers()->saveMany($answers_array);
                        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($submit->application_id, $submit->user_id);
                        $insertTeam = new InsertTeam($applicationDataForUser);
                        $insertTeam->addTeam();
                        return $submit;
                    }
                });
            } catch (\Exception $ob) {
                return $submit;
            }
        }

        $submit = Submit::with(['application.event', 'answers'])->where('id', $submit_id)->first();
        return $submit;
    }
}

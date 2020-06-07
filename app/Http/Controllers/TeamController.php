<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\User;
use App\Src\ApplicationHelpers\CreateNewSubmitFromExistingOne;
use Illuminate\Http\Request;
use App\Src\ApplicationHandlers\SubmitHandler;
use App\Src\UserHandler;
use App\Src\TeamHandler;
use App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers\InsertTeam;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Validator;


class TeamController extends Controller
{
    public function doAddUserToTeam($submit_id_for_copy, Request $request)
    {
        try {
            \Auth::guard()->logout();
            $user = UserHandler::createUserByEmail($request->query('email'));
            \Auth::guard()->login($user);

            $submit_for_copy = CreateNewSubmitFromExistingOne::getSubmitForCopy($submit_id_for_copy);

            CreateNewSubmitFromExistingOne::bindUserToSubmit($submit_for_copy, $user->id);

            $team = Team::where('submit_id', $submit_for_copy->id)->first();

            TeamHandler::bindUserToTeam(\Auth::user()->id, $team->id);

            return redirect()->route('home_event_status', ['event_name' => $submit_for_copy->application->event->event_name]);
        } catch (\Exception $ob) {
            return abort(404);
        }
    }

    public function doUnbindUserFromTeam($team_id, $user_id)
    {
        $team = Team::find($team_id);
        if ($team) {
            TeamHandler::unbindUserFromTeam($team_id, $user_id);
        }
    }

    protected function validatorForEditing(array $data)
    {
        return Validator::make($data, [
            'team_name' => ['required', 'string', 'max:255', 'min:2', 'unique:teams,team_name,' . \Auth::user()->id],
        ]);
    }


    public function editTeam($id, Request $request)
    {

        // $this->validatorForEditing($request->all())->validate();

        $team = Team::find($id);
        $team->update([
            'team_name' => $request->team_name,
            'country' => $request->country,
            'city' => $request->city,
            'university' => $request->university,
        ]);
    }


    public function showEditTeamForm($id, Request $request)
    {
        $team = Team::find($id)->load("users");
        return view('admin.edit_team', ["team" => $team]);
    }
}
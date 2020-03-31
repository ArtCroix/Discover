<?php

namespace App\Src\ApplicationHandlers;

use App\Src\ApplicationHandlers\AnswerHandler;
use App\Src\ApplicationHandlers\FileHandler;
use App\Src\ApplicationHandlers\SubmitHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class ApplicationHandler
{
    protected $application_id;
    protected $event_id;
    protected $request;
    protected $request_post;
    protected $request_files;
    protected $request_all;
    protected $user;

    public function __construct(int $application_id, Request $request, Authenticatable $user, Model $event)
    {
        $this->event = $event;
        $this->application_id = $application_id;
        $this->request = $request;
        $this->request_all = $request->all();
        $this->request_post = $request->post();
        $this->request_files = $request->allFiles();
        $this->user = $user;
    }

    public function createApplicationSubmit()
    {
        $submit = SubmitHandler::addSubmit($this->application_id, $this->user);

        $files_pathes = FileHandler::uploadFiles("events/{$this->event->event_dir_name}/applications/{$this->application_id}/users_data/{$this->user->id}/uploaded", $submit->id, $this->request_files);

        $this->request_post += $files_pathes;

        AnswerHandler::addAnswers($submit, $this->request_post);

        $applicationDataForUser = self::getApplicationDataForUser($this->application_id, $this->user->id);

        return $applicationDataForUser;
    }

    public static function getApplicationDataForUser(int $application_id, int $user_id): array
    {
        $application = \DB::select(
            'with A as (SELECT
            answers.`value` as answer,
            submit_id,
            submits.additional_data,
            user_id,
            question_id as temp_qid
            FROM
            submits
            INNER JOIN answers ON answers.submit_id = submits.id
            WHERE user_id=:user_id and submits.application_id=:application_id1)

            SELECT

            ifnull(answer,"") answer,
            submit_id,
            questions.id as question_id,
            application_id,
            description,
            ifnull(additional_data,"[]") additional_data,
            label,
            label_en,
            user_id,
            event_id,
            `name`,
            event_dir_name,
            event_name,
            questions.type,
            applications.type as application_type,
            applications.before_strategies,
            applications.after_strategies,
			applications.settings,
            questions.position,
            `value`,
            value_en,
            presentation,
            slot_name,
            presentation_en,
            rule,
            layout
            FROM A right join questions on questions.id = A.temp_qid
            INNER JOIN applications on applications.id=questions.application_id
            INNER JOIN events on events.id=applications.event_id
            WHERE questions.application_id=:application_id2 order by questions.position',
            ['user_id' => $user_id, 'application_id1' => $application_id, 'application_id2' => $application_id]
        );

        // $application = collect($application)->map(function ($x) {return (array) $x;})->toArray();

        // dd($application);
        return $application;
        // return collect($application)->map(function ($x) {return (array) $x;})->toArray();
    }

    public static function getEventApplicationsForUser(string $event_name, int $user_id): array
    {
        $applications = \DB::select(
            'with A as (
                SELECT
                    id,
                    user_id,
                    submits.application_id
                    FROM
                    submits
                    WHERE
                    submits.user_id = :user_id
            )
             SELECT  A.id, event_id, event_name, tab_title, A.application_id as submitted_application, user_id, applications.title, applications.settings, depends_on, applications.id as application_id from applications LEFT JOIN A on applications.id=A.application_id
             INNER JOIN `events` on applications.event_id=`events`.id where event_name=:event_name order by position',
            ['user_id' => $user_id, 'event_name' => $event_name]
        );
        return $applications;
    }

    public static function getTeamForEvent(string $event_name, int $user_id): array
    {
        $team = \DB::select(
            'with A as (SELECT
            event_team.team_id,
            team_name
            FROM
            users
            INNER JOIN event_team ON event_team.user_id = users.id
            INNER JOIN teams ON event_team.team_id = teams.id
            INNER JOIN `events` ON event_team.event_id = `events`.id
            WHERE
            events.event_name= :event_name AND
            event_team.user_id = :user_id
            )
            SELECT
            team_name,
            users.login,
            users.firstname,
            users.lastname,
            users.middlename,
            event_team.user_id,
            event_team.team_id
            FROM
            users
            INNER JOIN event_team ON event_team.user_id = users.id
            Inner JOIN A on event_team.team_id=A.team_id',
            ['user_id' => $user_id, 'event_name' => $event_name]
        );
        return $team;
    }
}

<?php

namespace App\Src\ApplicationHandlers;

use App\Models\Application\Application;
use App\Src\ApplicationHandlers\AnswerHandler;
use App\Src\ApplicationHandlers\FileHandler;
use App\Src\ApplicationHandlers\SubmitHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Models\Application\Submit;
use App\Src\ApplicationStrategies\ApplicationBeforeSubmitStrategyFactory;
use App\Src\ApplicationStrategies\ApplicationAfterSubmitStrategyFactory;

class ApplicationHandler
{
    protected $application_id;
    protected $event_id;
    protected $request;
    protected $request_post;
    protected $request_files;
    protected $request_all;
    protected $user;
    protected $additionalDataForResponse = [];

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
        $this->application = Application::find($this->application_id)->load('event');

        $applicationAfterStrategies = self::getAfterStrategies($this->application);

        $submit = SubmitHandler::addSubmit($this->application_id, $this->user);

        $files_pathes = FileHandler::uploadFiles("events/{$this->event->event_dir_name}/applications/{$this->application_id}/users_data/{$this->user->id}/uploaded", $submit->id, $this->request_files);

        $this->request_post += $files_pathes;

        AnswerHandler::addAnswers($submit, $this->request_post);

        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($this->application_id, $this->user->id);

        foreach ($applicationAfterStrategies as $afterStrategies) {
            foreach ($afterStrategies as $key => $afterStrategy) {
                $this->additionalDataForResponse[$key] = $afterStrategy::execute($applicationDataForUser);
            }
        }

        return response()->json(['status' => 'OK', 'applicationDataForUser' => $applicationDataForUser] + $this->additionalDataForResponse, 200);
    }

    public function editForUserApplicationSubmit()
    {
        $this->application = Application::find($this->application_id)->load('event');

        $applicationAfterStrategies = self::getAfterStrategies($this->application);

        $submit = SubmitHandler::addSubmit($this->application_id, $this->user);

        $files_pathes = FileHandler::uploadFiles("events/{$this->event->event_dir_name}/applications/{$this->application_id}/users_data/{$this->user->id}/uploaded", $submit->id, $this->request_files);

        $this->request_post += $files_pathes;

        AnswerHandler::addAnswers($submit, $this->request_post);

        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($this->application_id, $this->user->id);

        foreach ($applicationAfterStrategies as $afterStrategies) {
            foreach ($afterStrategies as $key => $afterStrategy) {
                $this->additionalDataForResponse[$key] = $afterStrategy::execute($applicationDataForUser);
            }
        }

        return response()->json(['status' => 'OK', 'applicationDataForUser' => $applicationDataForUser] + $this->additionalDataForResponse, 200);
    }

    public static function showApplicationForm(string $event_name, int $application_id, int $user_id)
    {
        $is_submitted = Submit::with('users')->where('application_id', $application_id)->whereHas('users', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        })->exists();

        $eventApplications = ApplicationHandler::getEventApplicationsForUser($event_name, $user_id);
        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($application_id, $user_id);
        $applicationBeforeStrategies = self::getBeforeStrategies(explode(",", $applicationDataForUser[0]->before_strategies));

        foreach ($applicationBeforeStrategies as $beforeStrategies) {
            foreach ($beforeStrategies as $key => $beforeStrategy) {
                $additionalDataForForm[$key] = $beforeStrategy::execute($applicationDataForUser);
            }
        }

        return view('events.form')->with(['applicationDataForUser' => $applicationDataForUser, 'eventApplications' => $eventApplications, 'application_id' => $application_id, 'strategies' => array_keys($applicationBeforeStrategies), 'additionalDataForForm' => $additionalDataForForm ?? [], 'is_submitted' => $is_submitted]);
    }

    public static function showApplicationFormForEdit(string $event_name, int $application_id, int $user_id)
    {
        $is_submitted = Submit::with('users')->where('application_id', $application_id)->whereHas('users', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        })->exists();

        $eventApplications = ApplicationHandler::getEventApplicationsForUser($event_name, $user_id);
        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($application_id, $user_id);
        $applicationBeforeStrategies = self::getBeforeStrategies(explode(",", $applicationDataForUser[0]->before_strategies));

        foreach ($applicationBeforeStrategies as $beforeStrategies) {
            foreach ($beforeStrategies as $key => $beforeStrategy) {
                $additionalDataForForm[$key] = $beforeStrategy::execute($applicationDataForUser);
            }
        }

        return view('admin.edit_form')->with(['applicationDataForUser' => $applicationDataForUser, 'eventApplications' => $eventApplications, 'application_id' => $application_id, 'strategies' => array_keys($applicationBeforeStrategies), 'additionalDataForForm' => $additionalDataForForm ?? [], 'is_submitted' => $is_submitted, 'user_id' => $user_id]);
    }

    public static function getApplicationDataForUser(int $application_id, int $user_id): array
    {
        $application = \DB::select(
            'with A as (SELECT
            answers.`value` as answer,
            submit_user.submit_id,
            submits.additional_data,
            submit_user.user_id,
            question_id as temp_qid
            FROM
            submits
            INNER JOIN submit_user ON submit_user.submit_id = submits.id
            INNER JOIN answers ON answers.submit_id = submits.id
            WHERE submit_user.user_id=:user_id and submits.application_id=:application_id1)

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
            display,
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
                    submit_user.user_id,
                    submits.application_id
                    FROM
                    submits
                    INNER JOIN submit_user ON submit_user.submit_id = submits.id
                    WHERE
                    submit_user.user_id = :user_id
            )
             SELECT  event_id, event_name, tab_title, A.application_id as submitted_application, user_id, applications.title, applications.settings, depends_on, applications.id as application_id from applications LEFT JOIN A on applications.id=A.application_id
             RIGHT JOIN `events` on applications.event_id=`events`.id where event_name=:event_name order by position',
            ['user_id' => $user_id, 'event_name' => $event_name]
        );
        return $applications;
    }

    public static function getTeamForEvent(string $event_name, int $user_id): array
    {
        $team = \DB::select(
            'with A as (select
            user_team.team_id,
            team_name
            FROM
            users
            INNER JOIN user_team ON user_team.user_id = users.id
            INNER JOIN teams ON user_team.team_id = teams.id
            INNER JOIN `events` on `events`.id=teams.event_id
            WHERE
            event_name = :event_name AND
            user_id = :user_id
            )
            SELECT
            team_name,
            users.login,
            users.firstname,
            users.lastname,
            users.middlename,
            user_team.user_id,
            user_team.team_id
            FROM
            users
            INNER JOIN user_team ON user_team.user_id = users.id
            Inner JOIN A on user_team.team_id=A.team_id',
            ['user_id' => $user_id, 'event_name' => $event_name]
        );
        return $team;
    }

    public static function getBeforeStrategies(array $applicationBeforeStrategies)
    {
        return ApplicationBeforeSubmitStrategyFactory::createApplicationStrategy($applicationBeforeStrategies);
    }

    public static function getAfterStrategies(Application $application)
    {
        $applicationAfterStrategies = explode(",", $application->after_strategies);
        // dd($applicationAfterStrategies);
        return ApplicationAfterSubmitStrategyFactory::createApplicationStrategy($applicationAfterStrategies);
    }

    public static function getAnswers()
    {
    }
}

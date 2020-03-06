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
            '

            with A as (SELECT

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
            ifnull(additional_data,"[]") additional_data,
            label,
            label_en,
            user_id,
            `name`,
            event_dir_name,
            questions.type,
            applications.type as app_type,
            position,
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
            WHERE questions.application_id=:application_id2 order by position',
            ['user_id' => $user_id, 'application_id1' => $application_id, 'application_id2' => $application_id]
        );

        // $application = collect($application)->map(function ($x) {return (array) $x;})->toArray();

        // dd($application);
        return $application;
        // return collect($application)->map(function ($x) {return (array) $x;})->toArray();
    }
}

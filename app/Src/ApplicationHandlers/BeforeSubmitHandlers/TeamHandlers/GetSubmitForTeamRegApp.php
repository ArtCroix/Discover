<?php

namespace App\Src\ApplicationHandlers\BeforeSubmitHandlers\TeamHandlers;

use App\Src\ApplicationHandlers\BeforeSubmitHandlers\AbstractBeforeSubmitHandler;

class GetSubmitForTeamRegApp extends AbstractBeforeSubmitHandler
{
    public function __construct(array $applicationDataForUser)
    {
        parent::__construct($applicationDataForUser);
        $this->user_id = \Auth::user()->id;
        $this->event_name = $applicationDataForUser[0]->event_name;
        $this->application_type = $applicationDataForUser[0]->application_type;
    }

    public function getTeamForEvent(): array
    {
        $answers = \DB::select(
            'SELECT
            answers.`value` as answer,
            questions.`name`
            FROM
            answers
            INNER JOIN submits ON answers.submit_id = submits.id
            INNER JOIN questions ON answers.question_id = questions.id
            WHERE
            submits.user_id = :user_id AND
            submits.application_id IN (SELECT applications.id from applications join `events` on applications.event_id=`events`.id where event_name = :event_name and applications.type = :application_type)',

            ['user_id' => $this->user_id, 'event_name' => $this->event_name, 'application_type' => 'team_registration']
        );
        return $answers;
    }
}

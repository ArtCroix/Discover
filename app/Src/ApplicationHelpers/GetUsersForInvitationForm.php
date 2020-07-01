<?php

namespace App\Src\ApplicationHelpers;

use App\Models\Application\Submit;
use App\User;

class GetUsersForInvitationForm
{
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
            event_name,
            questions.type,
            applications.type as application_type,
            applications.strategies,
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

        return $application;
    }
}

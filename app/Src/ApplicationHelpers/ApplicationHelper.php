<?php

namespace App\Src\ApplicationHelpers;

class ApplicationHelper
{
    public static function getApplicationDataForUser(int $application_id, int $user_id, string $locale): array
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
            applications.description,
            ifnull(additional_data,"[]") additional_data,
            label,
            label_en,
            default_value,
            user_id,
            event_id,
            price,
            `name`,
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

    //Получить все анкеты со статусом заполнения для пользователея в текущем мероприятии
    public static function getEventApplicationsForUser(string $event_name, int $user_id, string $locale): array
    {
        $applications = \DB::select(
            'with A as (
                SELECT
                submit_user.user_id,
                submits.application_id,
                applications.type,
                applications.admin_only
                FROM
                submits
                INNER JOIN submit_user ON submit_user.submit_id = submits.id 
                INNER JOIN applications ON submits.application_id = applications.id 
                WHERE
                submit_user.user_id = :user_id
            )
             SELECT  event_id, event_name, tab_title, A.application_id as submitted_application, user_id, applications.title, applications.settings, depends_on, applications.id as application_id, applications.type, applications.admin_only,
	        A.type AS submitted_application_type from applications LEFT JOIN A on applications.id=A.application_id
             RIGHT JOIN `events` on applications.event_id=`events`.id where event_name=:event_name and (forbidden_for_locale <> :locale or forbidden_for_locale is null) order by position ',
            ['user_id' => $user_id, 'event_name' => $event_name, 'locale' => $locale]
        );
        return $applications;
    }

    public static function addMissingQuestions(int $application_id, int $submit_id)
    {
        \DB::insert(
            "
            INSERT INTO answers (submit_id, question_id, value, application_id, created_at, updated_at) 
            SELECT
            avi.submit_id,
            avi.question_id,
            avi.default_value,
            avi.application_id,
            FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H:%i:%s') as created_at,
            FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H:%i:%s') as updated_at
FROM
	(
	SELECT DISTINCT
		answers.submit_id,
		questions.id AS question_id,
		questions.NAME,
		default_value,
		questions.application_id 
	FROM
		answers,
		questions 
	WHERE
		submit_id = :submit_id
		AND questions.application_id = :application_id 
	) avi
	LEFT JOIN answers a_v ON ( avi.submit_id = a_v.submit_id AND avi.question_id = a_v.question_id ) 
WHERE
	a_v.submit_id IS NULL 
AND NAME IS NOT NULL",
            ['application_id' => $application_id, 'submit_id' => $submit_id]

        );
    }
}

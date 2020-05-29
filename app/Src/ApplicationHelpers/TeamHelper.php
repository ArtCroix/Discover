<?php

namespace App\Src\ApplicationHelpers;

use App\Models\Application\Submit;
use App\User;

class TeamHelper
{
    public static function getTeamForEvent(string $event_name, int $user_id): array
    {
        $team = \DB::select(
            'with A as (select
            user_team.team_id,
            submit_id,
            event_name,
            application_id,
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
            A.team_id,
            application_id,
            event_name,
            submit_id,
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
}

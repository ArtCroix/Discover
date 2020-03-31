<?php

namespace App\Src\ApplicationStrategies;

class ApplicationBeforeSubmitStrategyFactory
{
    protected static $applicationStrategies = [
        'invitation' => [
            'answers_for_team_reg_app' => 'App\Src\ApplicationStrategies\BeforeSubmitStrategies\GetTeamMembersForInvitationStrategy',
        ],
    ];

    public static function createApplicationStrategy(array $applicationTypes)
    {
        return array_intersect_key(self::$applicationStrategies, array_flip($applicationTypes));
    }
}

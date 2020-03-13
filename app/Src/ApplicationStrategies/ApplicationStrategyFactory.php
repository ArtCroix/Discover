<?php

namespace App\Src\ApplicationStrategies;

class ApplicationStrategyFactory
{
    protected static $applicationStrategies = [
        'team_registration' => [
            'sended_emails' => 'App\Src\ApplicationStrategies\TeamNotifyStrategy',
            'users' => 'App\Src\ApplicationStrategies\TeamCreatingStrategy',
        ],
        'doc_creating' => ['created_docs' => 'App\Src\ApplicationStrategies\DocCreatingStrategy'],
    ];

    public static function createApplicationStrategy(array $applicationTypes)
    {
        return array_intersect_key(self::$applicationStrategies, array_flip($applicationTypes));
    }
}

<?php

namespace App\Src\ApplicationStrategies;

class ApplicationAfterSubmitStrategyFactory
{
    protected static $applicationStrategies = [
        'team_registration' => [
            'sended_emails' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\TeamNotifyStrategy',
            'users' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\TeamCreatingStrategy',
        ],
        'doc_creating' => ['created_docs' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\DocCreatingStrategy'],
    ];

    public static function createApplicationStrategy(array $applicationTypes)
    {
        return array_intersect_key(self::$applicationStrategies, array_flip($applicationTypes));
    }
}

<?php

namespace App\Src\ApplicationStrategies;

class ApplicationAfterSubmitStrategyFactory
{
    protected static $applicationStrategies = [
        'set_currency' => [
            'currency' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\SetCurrencyStrategy'
        ],
        'team_registration' => [
            'users' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\TeamCreatingStrategy',
            'sended_emails' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\TeamNotifyStrategy',
        ],
        'doc_creating' => ['created_docs' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\DocCreatingStrategy'],
        'doc_creating_invitation' => ['created_docs' => 'App\Src\ApplicationStrategies\AfterSubmitStrategies\DocCreatingInvitationStrategy'],
    ];

    public static function createApplicationStrategy(array $applicationTypes)
    {
        return array_intersect_key(self::$applicationStrategies, array_flip($applicationTypes));
    }
}

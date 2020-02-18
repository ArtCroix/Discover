<?php

namespace App\Src\ApplicationStrategies;

class ApplicationStrategyFactory
{
    protected static $applicationStrategies = [
        'team_registration' => 'App\Src\ApplicationStrategies\TeamRegistrationStrategy',
        'doc_creating' => 'App\Src\ApplicationStrategies\DocCreatingStrategy',
    ];

    public static function createApplicationStrategy(array $applicationTypes)
    {
        /*   foreach (self::$applicationStrategies as $key => $strategy) {
        if (in_array($strategy, $applicationTypes)) {
        yield $strategy;
        }
        } */
        /*  return array_filter(self::$applicationStrategies, fn($key) => in_array($key, $applicationTypes), ARRAY_FILTER_USE_KEY); */
        return array_intersect_key(self::$applicationStrategies, array_flip($applicationTypes));
    }
}

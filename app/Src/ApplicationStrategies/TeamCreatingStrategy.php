<?php

namespace App\Src\ApplicationStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers\InsertTeam;
use App\Src\ApplicationStrategies\InterfaceStrategy;

class TeamCreatingStrategy implements InterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new InsertTeam($applicationDataForUser))->addTeam();
    }
}

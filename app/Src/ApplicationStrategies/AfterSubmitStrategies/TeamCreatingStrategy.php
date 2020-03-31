<?php

namespace App\Src\ApplicationStrategies\AfterSubmitStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers\InsertTeam;
use App\Src\ApplicationStrategies\AfterSubmitStrategies\AfterSubmitInterfaceStrategy;


class TeamCreatingStrategy implements AfterSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new InsertTeam($applicationDataForUser))->addTeam();
    }
}

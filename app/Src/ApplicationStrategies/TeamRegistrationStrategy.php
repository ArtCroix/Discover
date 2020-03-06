<?php

namespace App\Src\ApplicationStrategies;

use App\Src\ApplicationHandlers\TeamHandlers\SendEmailToTeamMembers;
use App\Src\ApplicationStrategies\InterfaceStrategy;

class TeamRegistrationStrategy implements InterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new SendEmailToTeamMembers($applicationDataForUser))->sendEmails();
    }
}

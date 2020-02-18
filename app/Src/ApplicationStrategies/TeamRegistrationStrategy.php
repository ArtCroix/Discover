<?php

namespace App\Src\ApplicationStrategies;

use App\Src\ApplicationStrategies\InterfaceStrategy;
use App\Src\TeamHandlers\SendEmailToTeamMembers;

class TeamRegistrationStrategy implements InterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new SendEmailToTeamMembers($applicationDataForUser))->sendEmails();
    }
}

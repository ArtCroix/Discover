<?php

namespace App\Src\ApplicationStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers\SendEmailToTeamMembers;
use App\Src\ApplicationStrategies\InterfaceStrategy;

class TeamNotifyStrategy implements InterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new SendEmailToTeamMembers($applicationDataForUser))->sendEmails();
    }
}

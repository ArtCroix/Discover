<?php

namespace App\Src\ApplicationStrategies\AfterSubmitStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers\SendEmailToTeamMembers;
use App\Src\ApplicationStrategies\AfterSubmitStrategies\AfterSubmitInterfaceStrategy;


class TeamNotifyStrategy implements AfterSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new SendEmailToTeamMembers($applicationDataForUser))->sendEmails();
    }
}

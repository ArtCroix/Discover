<?php

namespace App\Src\ApplicationStrategies\BeforeSubmitStrategies;

use App\Src\ApplicationHandlers\BeforeSubmitHandlers\TeamHandlers\GetSubmitForTeamRegApp;
use App\Src\ApplicationStrategies\BeforeSubmitStrategies\BeforeSubmitInterfaceStrategy;


class GetTeamMembersForInvitationStrategy implements BeforeSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new GetSubmitForTeamRegApp($applicationDataForUser))->getSubmit();
    }
}

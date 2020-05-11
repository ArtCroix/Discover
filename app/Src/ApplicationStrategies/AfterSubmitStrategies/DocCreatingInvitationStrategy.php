<?php

namespace App\Src\ApplicationStrategies\AfterSubmitStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\DocHandlerInvitation;
use App\Src\ApplicationStrategies\AfterSubmitStrategies\AfterSubmitInterfaceStrategy;

class DocCreatingInvitationStrategy implements AfterSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new DocHandlerInvitation($applicationDataForUser))->createDocs();
    }
}

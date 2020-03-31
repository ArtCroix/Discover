<?php

namespace App\Src\ApplicationStrategies\AfterSubmitStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\DocHandler;
use App\Src\ApplicationStrategies\AfterSubmitStrategies\AfterSubmitInterfaceStrategy;

class DocCreatingStrategy implements AfterSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new DocHandler($applicationDataForUser))->createDocs();
    }
}

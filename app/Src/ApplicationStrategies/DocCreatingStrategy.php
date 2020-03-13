<?php

namespace App\Src\ApplicationStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\DocHandler;
use App\Src\ApplicationStrategies\InterfaceStrategy;

class DocCreatingStrategy implements InterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new DocHandler($applicationDataForUser))->createDocs();
    }
}

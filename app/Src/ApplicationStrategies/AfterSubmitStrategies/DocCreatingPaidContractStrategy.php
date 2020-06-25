<?php

namespace App\Src\ApplicationStrategies\AfterSubmitStrategies;

use App\Src\ApplicationHandlers\AfterSubmitHandlers\DocHandlerPaidContract;
use App\Src\ApplicationStrategies\AfterSubmitStrategies\AfterSubmitInterfaceStrategy;

class DocCreatingPaidContractStrategy implements AfterSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new DocHandlerPaidContract($applicationDataForUser))->createDocs();
    }
}

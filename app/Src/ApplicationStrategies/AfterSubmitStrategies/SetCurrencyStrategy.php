<?php

namespace App\Src\ApplicationStrategies\AfterSubmitStrategies;

use App\Src\ApplicationHandlers\PostSubmitHandlers\SetCurrency;
use App\Src\ApplicationStrategies\AfterSubmitStrategies\AfterSubmitInterfaceStrategy;


class SetCurrencyStrategy implements AfterSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser)
    {
        return (new SetCurrency($applicationDataForUser))->setCurrency();
    }
}

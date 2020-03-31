<?php

namespace App\Src\ApplicationStrategies\AfterSubmitStrategies;

interface AfterSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser);
}

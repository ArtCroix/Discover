<?php

namespace App\Src\ApplicationStrategies\BeforeSubmitStrategies;

interface BeforeSubmitInterfaceStrategy
{
    public static function execute(array $applicationDataForUser);
}

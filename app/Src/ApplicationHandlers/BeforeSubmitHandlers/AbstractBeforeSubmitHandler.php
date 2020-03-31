<?php

namespace App\Src\ApplicationHandlers\BeforeSubmitHandlers;

abstract class AbstractBeforeSubmitHandler
{
    protected $applicationDataForUser;

    public function __construct(array $applicationDataForUser)
    {
        $this->applicationDataForUser = $applicationDataForUser;
    }
    /* 
    public function getSubmitAdditionalData(array $additionalFields)
    {
        return json_decode($this->submit->additional_data) ?: (object) $additionalFields;
    } */
}

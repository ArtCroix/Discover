<?php

namespace App\Src\ApplicationHandlers\AfterSubmitHandlers;

use App\Src\ApplicationHandlers\AfterSubmitHandlers\AbstractPostSubmitHandler;

class SetCurrency extends AbstractPostSubmitHandler
{
    protected $currency;

    public function __construct(array $applicationDataForUser)
    {
        parent::__construct($applicationDataForUser);
        $this->currency = $this->locale === "ru" ? "rub" : "usd";
        $this->submitAdditionalData = $this->getSubmitAdditionalData(['currency' => null]);
        $this->submitAdditionalData->currency = $this->submitAdditionalData->currency ?? null;
    }

    public function setCurrency()
    {
        if ($this->submitAdditionalData->currency === null) {
            $this->submitAdditionalData->currency = $this->currency;
            $this->submit->update(['additional_data' => json_encode($this->submitAdditionalData)]);
        }
    }
}

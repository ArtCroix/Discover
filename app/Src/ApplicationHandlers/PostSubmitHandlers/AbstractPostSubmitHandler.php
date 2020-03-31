<?php

namespace App\Src\ApplicationHandlers\PostSubmitHandlers;

use App\Models\Application\Submit;

abstract class AbstractPostSubmitHandler
{
    protected $applicationDataForUser;
    protected $submitAdditionalData;
    protected $submit;
    protected $locale;

    public function __construct(array $applicationDataForUser)
    {
        $this->applicationDataForUser = $applicationDataForUser;

        foreach ($applicationDataForUser as $value) {
            if (isset($value->submit_id)) {
                $submit_id = $value->submit_id;
                break;
            }
        }

        $this->submit = Submit::find($submit_id);

        $this->locale = session('locale', 'ru');
    }

    public function getSubmitAdditionalData(array $additionalFields)
    {
        return json_decode($this->submit->additional_data) ?: (object) $additionalFields;
    }
}

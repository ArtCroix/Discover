<?php

namespace App\Src\ApplicationHandlers\AfterSubmitHandlers\TeamHandlers;

use App\Models\Team;
use App\User;
use App\Src\ApplicationHandlers\AfterSubmitHandlers\AbstractPostSubmitHandler;
use App\Src\ApplicationHelpers\TeamHelper;

class InsertTeam extends AbstractPostSubmitHandler
{
    protected $team_name;
    protected $country;
    protected $city;
    protected $university;
    protected $event_id;

    public function __construct(array $applicationDataForUser)
    {
        parent::__construct($applicationDataForUser);
        $this->submitAdditionalData = $this->getSubmitAdditionalData(['bound_to_team' => 0]);
        $this->submitAdditionalData->bound_to_team = $this->submitAdditionalData->bound_to_team ?? 0;
        $this->event_id = $applicationDataForUser[0]->event_id;

        foreach ($applicationDataForUser as $value) {
            switch ($value->name) {
                case 'team_name':
                    $this->team_name = $value->answer;
                    break;
                case 'country':
                    $this->country = $value->answer;
                    break;
                case 'city':
                    $this->city = $value->answer;
                    break;
                case 'university':
                    $this->university = $value->answer;
                    break;
            }
        }
    }

    public function addTeam()
    {
        $team = Team::updateOrCreate(
            ['id' => $this->submitAdditionalData->bound_to_team],
            [
                'application_id' => $this->submit->application_id,
                'submit_id' => $this->submit->id,
                'team_name' => $this->team_name,
                'event_id' =>  $this->event_id,
                'country' => $this->country,
                'city' => $this->city,
                'university' => $this->university,
            ]
        );
        if (!$this->submitAdditionalData->bound_to_team) {
            $this->submitAdditionalData->bound_to_team = $team->id;
            $this->submit->update(['additional_data' => json_encode($this->submitAdditionalData)]);
        }
    }
}

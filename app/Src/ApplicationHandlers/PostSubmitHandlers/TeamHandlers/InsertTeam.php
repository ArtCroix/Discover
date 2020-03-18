<?php

namespace App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers;

use App\Models\Team;
use App\User;
use App\Src\ApplicationHandlers\PostSubmitHandlers\AbstractPostSubmitHandler;

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
        // dd($this->submitAdditionalData);
        $team = Team::updateOrCreate(
            ['id' => $this->submitAdditionalData->bound_to_team],
            [
                'application_id' => $this->submit->application_id,
                'team_name' => $this->team_name,
                'country' => $this->country,
                'city' => $this->city,
                'university' => $this->university,
            ]
        );
        if (!$this->submitAdditionalData->bound_to_team) {
            $this->submitAdditionalData->bound_to_team = $team->id;
            $this->submit->update(['additional_data' => json_encode($this->submitAdditionalData)]);
        }
        /*         $team = Team::updateOrCreate(
                ['application_id' => $this->submit->application_id],
                [
                    'team_name' => $this->team_name,
                    'country' => $this->country,
                    'city' => $this->city,
                    'university' => $this->university,
                ]
            ); */
        User::find($this->submit->user_id)->events()->syncWithoutDetaching([$this->event_id => ["team_id" => $team->id]]);
    }

    public function addUserAndTeamToEvent()
    {
    }
}

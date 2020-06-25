<?php

namespace App\Src\ApplicationHandlers\AfterSubmitHandlers\TeamHandlers;

use App\Mail\TeamRegistered;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\AfterSubmitHandlers\AbstractPostSubmitHandler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendEmailToTeamMembers extends AbstractPostSubmitHandler
{
    protected $teamMembersEmails = [];

    public function __construct(array $applicationDataForUser)
    {
        parent::__construct($applicationDataForUser);
        $this->teamMembersEmails = $this->getTeamMembersEmails();
        $this->submitAdditionalData = $this->getSubmitAdditionalData(['processed_emails' => [], 'bound_to_team' => 0, 'currency' => 'rub']);
        $this->submitAdditionalData->processed_emails = $this->submitAdditionalData->processed_emails ?? [];
        $this->submitAdditionalData->bound_to_team = $this->submitAdditionalData->bound_to_team ?? 0;
        $this->submitAdditionalData->currency = $this->submitAdditionalData->currency ?? 'rub';
        $this->alreadyProcessedEmails = $this->submitAdditionalData->processed_emails;
        $this->emailsForSending = array_diff($this->teamMembersEmails, $this->alreadyProcessedEmails);
    }

    public function sendEmails()
    {
        $this->addTeamMembersEmailsToProcessed();
        if (count($this->emailsForSending) > 0) {
            foreach ($this->applicationDataForUser as $value) {
                if ($value->name == 'team_name' && $value->answer)
                    $team_name = $value->answer;
                if (strpos($value->name, 'firstname_') === 0 || strpos($value->name, 'coach_firstname') === 0)
                    $user_names[] = $value->answer;
                if (strpos($value->name, 'user_email') === 0)
                    $user_emails[] = $value->answer;
            }

            $i = 0;
            foreach ($this->emailsForSending as $emailForSending) {
                $add_team_member_url = URL::signedRoute('add_team_member', ['submit_id' => $this->submit->id, 'email' => $emailForSending]);
                Mail::to($emailForSending)->send(new TeamRegistered($add_team_member_url, $team_name, $user_names[$i++], $user_emails, $this->applicationDataForUser[0]->event_name, $this->submitAdditionalData->bound_to_team, $this->submitAdditionalData->currency));
            }
        }
    }

    public function addTeamMembersEmailsToProcessed()
    {
        $this->submitAdditionalData->processed_emails = $this->teamMembersEmails;
        $this->submit->update(['additional_data' => json_encode($this->submitAdditionalData)]);
    }

    public function getAlreadyProcessedEmails()
    {
        return $this->submit->additional_data->processed_emails;
    }

    public function getTeamMembersEmails()
    {
        $emails = [];
        foreach ($this->applicationDataForUser as $value) {
            if ($value->type == 'email' && $value->answer) {
                $emails[] = $value->answer;
            }
        }
        return $emails;
    }
}

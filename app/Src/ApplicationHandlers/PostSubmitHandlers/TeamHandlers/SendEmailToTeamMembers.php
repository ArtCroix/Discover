<?php

namespace App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers;

use App\Mail\TeamRegistered;
use App\Src\ApplicationHandlers\PostSubmitHandlers\AbstractPostSubmitHandler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendEmailToTeamMembers extends AbstractPostSubmitHandler
{
    protected $teamMembersEmails = [];

    public function __construct(array $applicationDataForUser)
    {
        parent::__construct($applicationDataForUser);
        $this->teamMembersEmails = $this->getTeamMembersEmails();
        $this->submitAdditionalData = $this->getSubmitAdditionalData(['processed_emails' => []]);
        $this->submitAdditionalData->processed_emails = $this->submitAdditionalData->processed_emails ?? [];
        $this->alreadyProcessedEmails = $this->submitAdditionalData->processed_emails;
        $this->emailsForSending = array_diff($this->teamMembersEmails, $this->alreadyProcessedEmails);
    }

    public function sendEmails()
    {
        $this->addTeamMembersEmailsToProcessed();
        if (count($this->emailsForSending) > 0) {

            foreach ($this->emailsForSending as $emailForSending) {
                $add_team_member_url = URL::signedRoute('add_team_member', ['submit_id' => $this->submit->id, 'email' => $emailForSending]);
                Mail::to($emailForSending)->send(new TeamRegistered($add_team_member_url));
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

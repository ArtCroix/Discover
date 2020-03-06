<?php

namespace App\Src\ApplicationHandlers\TeamHandlers;

use App\Mail\TeamRegistered;
use App\Models\Application\Submit;
use Illuminate\Support\Facades\Mail;

class SendEmailToTeamMembers
{
    protected $teamMembersEmails = [];
    protected $applicationDataForUser;
    protected $submitAdditionalData;

    public function __construct(array $applicationDataForUser)
    {
        $this->submit_id = $applicationDataForUser[0]->submit_id;
        $this->submit = Submit::find($this->submit_id);
        $this->applicationDataForUser = $applicationDataForUser;
        $this->teamMembersEmails = $this->getTeamMembersEmails();
        $this->submitAdditionalData = $this->getSubmitAdditionalData(['processed_emails' => []]);
        $this->alreadyProcessedEmails = $this->submitAdditionalData->processed_emails;
        $this->emailsForSending = array_diff($this->teamMembersEmails, $this->alreadyProcessedEmails);
    }

    public function sendEmails()
    {
        $this->addTeamMembersEmailsToProcessed();
        if (count($this->emailsForSending) > 0) {
            Mail::to($this->emailsForSending)->send(new TeamRegistered());
        }
    }

    public function addTeamMembersEmailsToProcessed()
    {
        $this->submitAdditionalData->processed_emails = $this->teamMembersEmails;
        $this->submit->update(['additional_data' => json_encode($this->submitAdditionalData)]);
    }

    public function getSubmitAdditionalData(array $additionalFields)
    {
        return json_decode($this->submit->additional_data) ?: (object) $additionalFields;
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

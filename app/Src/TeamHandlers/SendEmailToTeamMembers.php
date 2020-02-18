<?php

namespace App\Src\TeamHandlers;

use App\Mail\TeamRegistered;
use Illuminate\Support\Facades\Mail;

class SendEmailToTeamMembers
{
    protected $teamMembersEmails = [];

    protected $applicationDataForUser;

    public function __construct(array $applicationDataForUser)
    {
        $this->applicationDataForUser = $applicationDataForUser;
        $this->getTeamMembersEmails();
    }

    public function sendEmails()
    {
        Mail::to($this->teamMembersEmails)->send(new TeamRegistered());
    }

    public function getTeamMembersEmails()
    {
        foreach ($this->applicationDataForUser as $value) {
            if ($value->type == 'email' && $value->answer) {
                $this->teamMembersEmails[] = $value->answer;
            }
        }
    }
}

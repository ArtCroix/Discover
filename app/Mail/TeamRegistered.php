<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class TeamRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $add_team_member_url;
    public $team_name;
    public $user_name;
    public $user_emails;
    public $event_name;
    public $team_id;
    public $currency;

    public function __construct($add_team_member_url, $team_name, $user_name, $user_emails, $event_name, $team_id, $currency)
    {
        $this->add_team_member_url = $add_team_member_url;
        $this->team_name = $team_name;
        $this->user_name = $user_name;
        $this->user_emails = $user_emails;
        $this->event_name = $event_name;
        $this->team_id = $team_id;
        $this->currency = $currency;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('workshops@it-edu.com', session('locale', 'ru') == 'ru' ? 'Команда Discover' : 'Discover Team')
            ->subject(session('locale', 'ru') == 'ru' ? 'Команда Discover - регистрация команды' : 'Discover command - team registration')
            ->view('emails.email_for_team_reg');
    }
}

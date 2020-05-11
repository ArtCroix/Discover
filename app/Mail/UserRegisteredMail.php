<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
            ->subject(session('locale', 'ru') == 'ru' ? 'Команда Discover - подтверждение учетной записи' : 'Discover command - account confirmation')
            ->view('emails.user_reg_verify');
    }
}

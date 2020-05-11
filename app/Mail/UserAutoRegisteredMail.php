<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAutoRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
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
            ->view('emails.user_auto_reg');
    }
}

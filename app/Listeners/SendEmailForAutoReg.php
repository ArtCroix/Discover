<?php

namespace App\Listeners;

use App\User;
use App\Events\AutoUserRegistered;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAutoRegisteredMail;

class SendEmailForAutoReg
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AutoUserRegistered  $event
     * @return void
     */
    public function handle(AutoUserRegistered $event)
    {
        Mail::to($event->user->email)->send(new UserAutoRegisteredMail($event->user, $event->password));
    }
}

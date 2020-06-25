<?php

namespace App\Policies;

use App\Models\Event;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAdminOnly(User $user, Event $event)
    {
        if ($event->admin_only === 1 && $user->role === "admin") {
            return true;
        } elseif ($event->admin_only === 0) {
            return true;
        }
        return false;
    }
}

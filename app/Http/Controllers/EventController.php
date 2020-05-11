<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class EventController extends Controller
{
    /*     public function __construct()
    {
        $this->middleware('auth');
    }
 */
    public function eventStatus(string $event_name)
    {
        $user_id = \Auth::user()->id;
        $team = ApplicationHandler::getTeamForEvent($event_name, $user_id);
        $eventApplications = ApplicationHandler::getEventApplicationsForUser($event_name, Auth::user()->id);
        return view('events.event', [
            'event' => Event::where('event_name', request()->event_name)->first(),
            'eventApplications' => $eventApplications,
            'team' => $team
        ]);
    }
}

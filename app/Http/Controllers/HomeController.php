<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::with("teams.users")->orderBy('created_at', 'desc')->get();
        // 
        // dd($events->find(1)->users()->where("id", 83)->get());
        /*   dd($events->find(1)->teams()->where("team_name", "Exhibition Team")->first()->users()->wherePivot("user_id", 83)->get()); */
        // dd(($events->find(1)->user_team)->isEmpty());
        return view('home', [
            'events' => $events,
        ]);
    }

    public function event_status(string $event_name)
    {
        $user_id = \Auth::user()->id;
        $team = ApplicationHandler::getTeamForEvent($event_name, $user_id);
        $eventApplications = ApplicationHandler::getEventApplicationsForUser($event_name, Auth::user()->id);
        // dd($team);
        return view('events.event', [
            'event' => Event::where('event_name', request()->event_name)->first(),
            'app_submits' => Submit::where("user_id", Auth::user()->id)->get('application_id'),
            'eventApplications' => $eventApplications,
            'team' => $team
        ]);
    }
}

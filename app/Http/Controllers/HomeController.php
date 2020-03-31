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

        $events = Event::orderBy('created_at', 'desc')->get();
        // 
        // dd($events);
        return view('home', [
            'events' => $events,
        ]);
    }

    public function myHome()
    {
        return view('myhome');
    }

    public function event_status(string $event_name)
    {
        $user_id = \Auth::user()->id;
        $team = ApplicationHandler::getTeamForEvent($event_name, $user_id);
        $eventApplications = ApplicationHandler::getEventApplicationsForUser($event_name, Auth::user()->id);
        return view('events.event', [
            'event' => Event::where('event_name', request()->event_name)->first(),
            'app_submits' => Submit::where("user_id", Auth::user()->id)->get('application_id'),
            'eventApplications' => $eventApplications,
            'team' => $team
        ]);
    }

    public function profile_status()
    {
        return view('profile', []);
    }

    public function edit_profile()
    {
        $user = \Auth::user();
        return view('edit_profile', ["user" => $user]);
    }

    public function edit_password()
    {
        $user = \Auth::user();
        return view('edit_password', ["user" => $user]);
    }
}

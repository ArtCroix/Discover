<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Auth;

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

        // dd($events);
        return view('home', [
            'events' => $events,
        ]);
    }

    public function myHome()
    {
        return view('myhome');
    }

    public function event_status()
    {
        return view('event', [
            'event' => Event::where('event_name', request()->event_name)->first(),
            'app_submits' => Submit::where("user_id", Auth::user()->id)->get('application_id'),
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

    public function getEventApp(string $event_name, int $application_id)
    {
        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($application_id, Auth::user()->id);
        return view('home.event_info')->with(['applicationDataForUser' => $applicationDataForUser]);
    }
}

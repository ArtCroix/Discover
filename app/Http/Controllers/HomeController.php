<?php

namespace App\Http\Controllers;

use App\Event;
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
        return view('home', [
            'events' => $events,
        ]);
    }

    public function my_index()
    {

        return view('myhome');
    }

    public function event_status()
    {
        return view('event', [
            'event' => Event::where('event_name', request()->event_name)->first(),
        ]);
    }

    public function profile_status()
    {
        return view('profile', [
        ]);
    }

    public function getEventApp(string $event_name, int $application_id)
    {
        // dd(Auth::user()->id);
        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($application_id, Auth::user()->id);
        // dd($application);

        return view('home.event_info')->with(['applicationDataForUser' => $applicationDataForUser]);
    }

    public function myHome()
    {
        return view('home.home');
    }
}

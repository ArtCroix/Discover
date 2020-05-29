<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Src\ApplicationHelpers\ApplicationHelper;
use App\Src\ApplicationHelpers\TeamHelper;

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
}

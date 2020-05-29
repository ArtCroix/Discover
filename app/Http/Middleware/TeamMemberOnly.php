<?php

namespace App\Http\Middleware;

use App\Models\Application\Application;
use App\Models\Application\Submit;
use Closure;
use App\Src\ApplicationHelpers\TeamHelper;

class TeamMemberOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $event_name = $request->route()->parameter('event_name');
        $team = TeamHelper::getTeamForEvent($event_name, \Auth::user()->id);
        // dd($team);
        if (empty($team)) {
            return response("Доступно только членам команды", 200);
        }
        return $next($request);
    }
}

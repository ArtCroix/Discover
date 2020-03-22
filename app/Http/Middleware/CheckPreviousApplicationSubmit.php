<?php

namespace App\Http\Middleware;

use App\Models\Application\Application;
use App\Models\Application\Submit;
use Closure;

class CheckPreviousApplicationSubmit
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
        $application = Application::find($request->app_id)->load('event');
        $locale = app()->getLocale();
        if (isset($application->depends_on)) {
            $submit = Submit::where("user_id", \Auth::user()->id)->where("application_id", $application->depends_on)->first();
            if (!isset($submit)) {
                $link = Application::find($application->depends_on)->load('event');
                return response("Перед заполнением этой формы необходимо заполнить форму:
                    <a href='/home/event/{$application->event->event_name}/app/{$application->depends_on}/{$locale}' title='{$link->title}'>" . json_decode($link->title, true)[app()->getLocale()] . "</a>", 200);
            }
        }
        return $next($request);
    }
}

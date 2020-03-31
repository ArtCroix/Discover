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
        $depends_on = explode(",", $application->depends_on);
        if (isset($application->depends_on)) {
            $submits = Submit::where("user_id", \Auth::user()->id)->whereIn("application_id", $depends_on)->get();
            $submitted_applications = $submits->pluck('application_id')->toArray();

            // dd(array_diff($depends_on, $submitted_applications));
            if ($submits->isEmpty() || $submits->count() < count($depends_on)) {
                $depends_on = array_diff($depends_on, $submitted_applications);
                $links = Application::whereIn("id", $depends_on)->get()->load('event');
                $hrefs = "<ul>";
                foreach ($links as $link) {
                    // if(!in_array())
                    $hrefs .= "<p><a href='/home/event/{$application->event->event_name}/app/{$link->id}/{$locale}' title='{$link->title}'>" . json_decode($link->title, true)[app()->getLocale()] . "</a></p>";
                }
                $hrefs .= "</ul>";
                return response("Перед заполнением этой формы необходимо заполнить формы:<br>$hrefs", 200);
            }
        }
        return $next($request);
    }
}

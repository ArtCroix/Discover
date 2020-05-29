<?php

namespace App\Http\Middleware;

use App\Models\Application\Application;
use App\Models\Application\Submit;
use Closure;

class CheckApplicationLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $forbidden_for_locale)
    {
        $locale = app()->getLocale();
        if ($locale === $forbidden_for_locale) {
            return response("<p>Не доступно для текущей локали</p><p>Access denied for current locale</p>", 200);
        }

        return $next($request);
    }
}

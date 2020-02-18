<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SetDefaultLocaleForUrls
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
        // URL::defaults(['locale' => 'en']);
        $locale = \Route::current()->parameters['locale'] ?? str_replace('_', '-', app()->getLocale());
        \App::setLocale($locale);
        /*         if (!session()->has('vr2019_locale')) { }
        session(['vr2019_locale' => $locale]); */

        return $next($request);
    }
}

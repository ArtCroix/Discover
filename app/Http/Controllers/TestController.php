<?php

namespace App\Http\Controllers;

use App\Src\ApplicationHelpers\CreateNewSubmitFromExistingOne;
use Illuminate\Http\Request;
use App\Src\ApplicationHandlers\SubmitHandler;
use App\Src\UserHandler;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\PostSubmitHandlers\TeamHandlers\InsertTeam;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHelpers\PaymentHelper;

class TestController extends Controller
{
    public function test(Request $request)
    {
        PaymentHelper::calculatePriceForTeam('example_event', 75);
        // dd(array_merge($request->route()->parameters(), ['locale' => 'ru'], $request->all()));
        // dd($request->route()->parameters());
        $request->route()->setParameter('locale', 'en'); //new parameter value
        $parameters = \Route::current()->Parameters();
        $uri = \Route::current()->uri();
        $uri = substr($uri, 0, strpos($uri, '/{'));
        $full_url = $request->root()  . '/' . $uri . '/' . implode('/', $parameters) . ($request->getQueryString() ? "?" . $request->getQueryString() : "");
        dd(route($request->route()->getName(), array_merge($request->route()->parameters(), ['locale' => 'en'])) . (request()->getQueryString() ? "?" . request()->getQueryString() : ""));
        dd($uri);
        dd($request->fullUrlWithQuery($request->all()));
        /*   $submit1 = Submit::with('users')->where('application_id', 1)->whereHas('users', function ($q) {
            $q->whereIn('user_id', [83]);
        })->first();

        dd($submit1);
        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser(1, 83);
        dd($applicationDataForUser); */
    }
}

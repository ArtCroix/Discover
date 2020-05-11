<?php

namespace App\Http\Controllers;

use App\Src\ApplicationHelpers\CreateNewSubmitFromExistingOne;
use Illuminate\Http\Request;
use App\Src\ApplicationHandlers\SubmitHandler;

class SubmitController extends Controller
{
    public function doCopySubmit($submit_id, Request $request)
    {
        $submit = CreateNewSubmitFromExistingOne::copySubmit($submit_id, $request->query('email'));
        return redirect()->route('home_event_status', ['event_name' => $submit->application->event->event_name]);
    }

    public function doCopySubmittest($submit_id, Request $request)
    {
        $submit = CreateNewSubmitFromExistingOne::copySubmit($submit_id, $request->query('email'));
        return redirect()->route('home_event_status', ['event_name' => $submit->application->event->event_name]);
    }

    public static function doDeleteFileFromApplicationSubmit(Request $request)
    {
        SubmitHandler::deleteFileFromApplicationSubmit($request);
    }
}

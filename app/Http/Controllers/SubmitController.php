<?php

namespace App\Http\Controllers;

use App\Src\ApplicationHelpers\CreateNewSubmitFromExistingOne;
use Illuminate\Http\Request;

class SubmitController extends Controller
{
    public function doCopySubmit($submit_id, Request $request)
    {
        $submit = CreateNewSubmitFromExistingOne::copySubmit($submit_id, $request->query('email'));
        return redirect()->route('home_event_status', ['event_name' => $submit->application->event->event_name]);
    }
}

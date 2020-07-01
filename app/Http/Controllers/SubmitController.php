<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use Illuminate\Http\Request;
use App\Src\ApplicationHandlers\SubmitHandler;

class SubmitController extends Controller
{
    public static function doDeleteFileFromApplicationSubmit(Request $request, $application_id)
    {
        $event = Application::find($application_id)->event;
        $user_id = \Auth::user()->id;
        $store_path = "events/{$event->event_dir_name}/applications/{$application_id}/users_data/{$user_id}/uploaded";
        SubmitHandler::deleteFileFromApplicationSubmit($request, $store_path);
    }
}

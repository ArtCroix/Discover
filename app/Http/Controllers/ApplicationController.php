<?php

namespace App\Http\Controllers;

use App\Application\Application;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHandlers\SubmitHandler;
use App\Src\ApplicationHandlers\ValidationHandler;
use App\Src\ApplicationStrategies\ApplicationStrategyFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    protected $application;
    protected $application_id;
    protected $event_id;
    protected $request;
    protected $request_post;
    protected $request_files;
    protected $request_all;
    protected $user;
    protected $additionalDataForResponse = [];
    protected $applicationStrategies = [];

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->application_id = $request->route()->parameter('application_id');
        $this->application = Application::find($this->application_id)->load('event');
        $this->event = $this->application->event;
        $this->request = $request;
        $this->request_all = $request->all();
        $this->request_post = $request->post();
        $this->request_files = $request->allFiles();
        $this->applicationStrategies = $this->getStrategies();
    }

    public function doCreateApplicationSubmit(int $application_id, Request $request)
    {
        // dd($request->all());

        $validator = ValidationHandler::validateAppData($this->application_id, $this->request_post, $this->request_files);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $applicationStrategies = $this->getStrategies();
        // dd($applicationStrategies);
        $appHandler = new ApplicationHandler($application_id, $request, Auth::user(), $this->event);

        $applicationDataForUser = $appHandler->createApplicationSubmit();

        // dd($applicationDataForUser);
        //  print_r($applicationDataForUser);
        // dd($applicationDataForUser);

        foreach ($this->applicationStrategies as $key => $strategy) {
            $this->additionalDataForResponse[$key] = $strategy::execute($applicationDataForUser);
        }

        // dd($applicationStrategies);
        return response()->json(['status' => 'OK', 'applicationDataForUser' => $applicationDataForUser] + $this->additionalDataForResponse, 200);
    }

    public function getStrategies()
    {
        $applicationTypes = explode(",", $this->application->type);
        // dd($applicationTypes);
        return ApplicationStrategyFactory::createApplicationStrategy($applicationTypes);
    }

    public static function doDeleteFileFromApplicationSubmit()
    {
        SubmitHandler::deleteFileFromApplicationSubmit();
    }
    /*
public static function doGetListOfUploadedFiles($question_id, $submit_id)
{
return response(['uploaded_files' => json_encode(FileHandler::getListOfUploadedFiles($question_id, $submit_id))]);
} */
}

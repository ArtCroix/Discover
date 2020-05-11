<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHandlers\ValidationHandler;
use App\Src\ApplicationStrategies\ApplicationAfterSubmitStrategyFactory;
use App\Src\ApplicationStrategies\ApplicationBeforeSubmitStrategyFactory;
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

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['doCopySubmit']]);
        $this->request = $request;
        $this->request_all = $request->all();
        $this->request_post = $request->post();
        $this->request_files = $request->allFiles();
    }

    public function doShowApplicationForm(string $event_name, int $application_id)
    {
        return ApplicationHandler::showApplicationForm($event_name, $application_id, \Auth::id());
    }

    public function doCreateApplicationSubmit(int $application_id, Request $request)
    {
        $validator = ValidationHandler::validateAppData($application_id, $this->request_post, $this->request_files);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        session(['locale' => app()->getLocale()]);
        $this->application = Application::find($application_id)->load('event');

        $this->event = $this->application->event;
        // dd(Auth::user());
        $appHandler = new ApplicationHandler($application_id, $request, Auth::user(), $this->event);
        return  $appHandler->createApplicationSubmit();
    }

    public function getTabsData(string $event_name)
    {
        ApplicationHandler::getEventApplicationsForUser($event_name, \Auth::user()->id);
    }

    public function showAppAnswers(int $app_id)
    {
        return view('admin.app_answers');

        // ApplicationHandler::getEventApplicationsForUser($event_name, \Auth::user()->id);
    }

    public function getAppAnswers(string $event_name)
    {
        // ApplicationHandler::getEventApplicationsForUser($event_name, \Auth::user()->id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHandlers\SubmitHandler;
use App\Src\ApplicationHandlers\ValidationHandler;
use App\Src\ApplicationHelpers\CreateNewSubmitFromExistingOne;
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
        // $this->middleware('auth');
        $this->middleware('auth', ['except' => ['doCopySubmit']]);
        $this->request = $request;
        $this->request_all = $request->all();
        $this->request_post = $request->post();
        $this->request_files = $request->allFiles();
    }

    public function doCreateApplicationSubmit(int $application_id, Request $request)
    {
        $this->application = Application::find($application_id)->load('event');

        $this->event = $this->application->event;

        session(['locale' => app()->getLocale()]);

        $applicationAfterStrategies = $this->getAfterStrategies($this->application);

        $validator = ValidationHandler::validateAppData($application_id, $this->request_post, $this->request_files);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $appHandler = new ApplicationHandler($application_id, $request, Auth::user(), $this->event);

        $applicationDataForUser = $appHandler->createApplicationSubmit();
        // dd($applicationDataForUser);
        foreach ($applicationAfterStrategies as $afterStrategies) {
            foreach ($afterStrategies as $key => $afterStrategy) {
                $this->additionalDataForResponse[$key] = $afterStrategy::execute($applicationDataForUser);
            }
        }
        return response()->json(['status' => 'OK', 'applicationDataForUser' => $applicationDataForUser] + $this->additionalDataForResponse, 200);
    }

    public function getAfterStrategies(Application $application)
    {
        $applicationAfterStrategies = explode(",", $application->after_strategies);
        return ApplicationAfterSubmitStrategyFactory::createApplicationStrategy($applicationAfterStrategies);
    }

    public function getBeforeStrategies(array $applicationBeforeStrategies)
    {
        return ApplicationBeforeSubmitStrategyFactory::createApplicationStrategy($applicationBeforeStrategies);
    }

    public static function doDeleteFileFromApplicationSubmit()
    {
        SubmitHandler::deleteFileFromApplicationSubmit();
    }

    public function showApplicationForm(string $event_name, int $application_id)
    {
        $is_submitted = Submit::where('user_id', \Auth::user()->id)->where('application_id', $application_id)->exists();
        $eventApplications = ApplicationHandler::getEventApplicationsForUser($event_name, Auth::user()->id);
        $applicationDataForUser = ApplicationHandler::getApplicationDataForUser($application_id, Auth::user()->id);
        $applicationBeforeStrategies = $this->getBeforeStrategies(explode(",", $applicationDataForUser[0]->before_strategies));
        // dd($applicationBeforeStrategies);

        foreach ($applicationBeforeStrategies as $beforeStrategies) {
            foreach ($beforeStrategies as $key => $beforeStrategy) {
                $additionalDataForForm[$key] = $beforeStrategy::execute($applicationDataForUser);
            }
        }

        return view('events.form')->with(['applicationDataForUser' => $applicationDataForUser, 'eventApplications' => $eventApplications, 'application_id' => $application_id, 'strategies' => array_keys($applicationBeforeStrategies), 'additionalDataForForm' => $additionalDataForForm ?? [], 'is_submitted' => $is_submitted]);
    }
}

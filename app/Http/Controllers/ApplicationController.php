<?php

namespace App\Http\Controllers;

use App\Src\ApplicationHelpers\ApplicationHelper;
use App\Models\Application\Application;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHandlers\ValidationHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $this->forbidden_for_locale = Application::find($request->route()->parameter('application_id'))->forbidden_for_locale;
        $this->middleware('check_application_locale:' . $this->forbidden_for_locale, ['only' => ['doShowApplicationForm']]);
    }

    public function doShowApplicationForm(string $event_name, int $application_id, string $locale = 'ru')
    {
        return ApplicationHandler::showApplicationForm($event_name, $application_id, \Auth::id(), 'events.form', $locale);
    }

    public function doCreateApplicationSubmit(int $application_id, $user_id = null, Request $request)
    {
        if ($user_id !== null) {
            Auth::onceUsingId($user_id);
        }

        $validator = ValidationHandler::validateAppData($application_id, $this->request_post, $this->request_files);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        session(['locale' => app()->getLocale()]);
        $this->application = Application::find($application_id)->load('event');
        $this->event = $this->application->event;
        $appHandler = new ApplicationHandler($application_id, $request, Auth::user(), $this->event);
        return  $appHandler->createApplicationSubmit();
    }

    public function showApplicationCreateForm()
    {
        return view('events.create_event');
    }

    public function showApplicationEditForm($event_id)
    {
        $event = Application::find($event_id);
        // dd(json_decode($event->title));
        return view('events.edit_event')->with(['event' => $event]);
    }

    /* public function doCreateApplication(Request $request)
    {
        $this->validatorForCreate($request->all())->validate();
        ApplicationHandler::createApplication($request->all());
    }

    public function doEditApplication($event_id, Request $request)
    {
        $this->validatorForEdit($request->all(), $event_id)->validate();
        ApplicationHandler::editApplication($request->all(), $event_id);
    }

    protected function validatorForCreate(array $data)
    {
        return Validator::make($data, [
            'event_name' => ['required', 'regex:/(^([a-zA-Z_]+)(\d+)?$)/u', 'string', 'max:20', 'min:4', 'unique:events'],
            'full_name_ru' => ['required', 'string', 'max:255'],
            'full_name_en' => ['string', 'max:255'],

        ]);
    }

    protected function validatorForEdit(array $data, $event_id)
    {
        return Validator::make($data, [
            'event_name' => ['required', 'regex:/(^([a-zA-Z_]+)(\d+)?$)/u', 'string', 'max:20', 'min:4', 'unique:events,event_name,' .  $event_id],
            'full_name_ru' => ['required', 'string', 'max:255',],
            'full_name_en' => ['string', 'max:255',],

        ]);
    } */
}

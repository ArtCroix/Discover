<?php

namespace App\Src\ApplicationHandlers;

use App\Models\Application\Application;
use App\Models\Application\Question;
use App\Models\Event;
use App\Src\ApplicationHandlers\AnswerHandler;
use App\Src\ApplicationHelpers\ApplicationHelper;
use App\Src\ApplicationHandlers\FileHandler;
use App\Src\ApplicationHandlers\SubmitHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Models\Application\Submit;
use App\Src\ApplicationStrategies\ApplicationBeforeSubmitStrategyFactory;
use App\Src\ApplicationStrategies\ApplicationAfterSubmitStrategyFactory;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationHandler
{
    protected $application_id;
    protected $event_id;
    protected $request;
    protected $request_post;
    protected $request_files;
    protected $request_all;
    protected $user;
    protected $additionalDataForResponse = [];

    public function __construct(int $application_id, Request $request, Authenticatable $user, Model $event)
    {
        $this->event = $event;
        $this->application_id = $application_id;
        $this->request = $request;
        $this->request_all = $request->all();
        $this->request_post = $request->post();
        $this->request_files = $request->allFiles();
        $this->user = $user;
    }

    public function createApplicationSubmit()
    {
        $this->application = Application::find($this->application_id)->load(['questions']);

        $applicationAfterStrategies = self::getAfterStrategies($this->application);

        $submit = SubmitHandler::addSubmit($this->application_id, $this->user);

        $files_pathes = FileHandler::uploadFiles("events/{$this->event->event_name}/applications/{$this->application_id}/users_data/{$this->user->id}/uploaded", $submit->id, $this->request_files);

        $this->request_post += $files_pathes;

        AnswerHandler::addAnswers($submit, $this->request_post);

        ApplicationHelper::addMissingQuestions($this->application_id, $submit->id);

        $applicationDataForUser = ApplicationHelper::getApplicationDataForUser($this->application_id, $this->user->id, app()->getLocale());

        foreach ($applicationAfterStrategies as $afterStrategies) {
            foreach ($afterStrategies as $key => $afterStrategy) {
                $this->additionalDataForResponse[$key] = $afterStrategy::execute($applicationDataForUser);
            }
        }

        return response()->json(['status' => 'OK', 'applicationDataForUser' => $applicationDataForUser] + $this->additionalDataForResponse, 200);
    }

    public static function showApplicationForm(string $event_name, int $application_id, int $user_id, string $view, string $locale)
    {
        $dataForApplicationForm = self::getDataForApplicationForm($event_name, $application_id, $user_id, $locale);

        return view($view)->with(['applicationDataForUser' => $dataForApplicationForm['applicationDataForUser'], 'eventApplications' => $dataForApplicationForm['eventApplications'], 'application_id' => $application_id, 'strategies' => array_values(
            $dataForApplicationForm['applicationBeforeStrategies']
        ), 'additionalDataForForm' => $dataForApplicationForm['additionalDataForForm'] ?? [], 'is_submitted' => $dataForApplicationForm['is_submitted'], 'user_id' => $user_id, 'app_files' => $dataForApplicationForm['app_files']]);
    }

    public static function getDataForApplicationForm(string $event_name, int $application_id, int $user_id, string $locale)
    {
        $is_submitted = Submit::with('users')->where('application_id', $application_id)->whereHas('users', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        })->exists();

        $app_files_dir = "events/{$event_name}/applications/{$application_id}/files_for_download";
        $app_files_dir_for_locale = "events/{$event_name}/applications/{$application_id}/files_for_download/{$locale}";
        $app_files = [];
        $common_files = Storage::files($app_files_dir);
        $locale_files = Storage::files($app_files_dir_for_locale);
        $app_files = [...$common_files, ...$locale_files];
        $eventApplications = ApplicationHelper::getEventApplicationsForUser($event_name, $user_id, $locale);
        $applicationDataForUser = ApplicationHelper::getApplicationDataForUser($application_id, $user_id, $locale);
        $applicationBeforeStrategies = self::getBeforeStrategies(explode(",", $applicationDataForUser[0]->before_strategies));

        foreach ($applicationBeforeStrategies as $beforeStrategies) {
            foreach ($beforeStrategies as $key => $beforeStrategy) {
                $additionalDataForForm[$key] = $beforeStrategy::execute($applicationDataForUser);
            }
        }
        // dd($additionalDataForForm);
        return ['applicationDataForUser' => $applicationDataForUser, 'eventApplications' => $eventApplications, 'application_id' => $application_id, 'applicationBeforeStrategies' => array_keys($applicationBeforeStrategies), 'additionalDataForForm' => $additionalDataForForm ?? [], 'is_submitted' => $is_submitted, 'app_files' => $app_files];
    }

    public static function getBeforeStrategies(array $applicationBeforeStrategies)
    {
        return ApplicationBeforeSubmitStrategyFactory::createApplicationStrategy($applicationBeforeStrategies);
    }

    public static function getAfterStrategies(Application $application)
    {
        $applicationAfterStrategies = explode(",", $application->after_strategies);
        return ApplicationAfterSubmitStrategyFactory::createApplicationStrategy($applicationAfterStrategies);
    }

    public static function deleteUserDataFromTeamApplication(string $email, int $submit_id)
    {
        $submit = Submit::find($submit_id)->load("answers.question");
        $answers = Submit::find($submit_id)->load("answers.question")->answers()->get();

        foreach ($answers as $key => $answer) {
            if ($answer->value === $email) {
                $index = Str::afterLast($answer->question->name, "_");
                \DB::update(
                    'UPDATE answers inner join questions on answers.question_id=questions.id 
                    set answers.value="" where submit_id= :submit_id and questions.class= :class',
                    ['class' => "user_" . $index, 'submit_id' => $submit_id]
                );
            }
        }
        $submitAdditionalData = json_decode($submit->additional_data);
        $processed_emails = $submitAdditionalData->processed_emails;
        $processed_emails = array_diff($processed_emails, [$email]);
        $submitAdditionalData->processed_emails = $processed_emails;
        $submit->update(['additional_data' => json_encode($submitAdditionalData)]);
    }
}

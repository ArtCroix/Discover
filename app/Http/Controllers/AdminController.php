<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\User;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\UserHandler;
use App\Src\TeamHandler;
use App\Src\ApplicationHandlers\SubmitHandler;
use App\Models\Application\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Src\ApplicationHandlers\AnswerHandler;
use App\Models\Application\Question;
use App\Src\EventHandler;

class AdminController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->request_all = $request->all();
        $this->request_post = $request->post();
        $this->request_files = $request->allFiles();
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function showEvents()
    {
        $events = Event::all();
        return view('admin.events')->with(['events' => $events]);
    }

    public function showEventInfo($event_name)
    {
        $event = Event::where("event_name", $event_name)->first()->load(["applications", "teams"]);
        // dd($event->teams);
        return view('admin.event')->with(['event' => $event]);
    }

    public function showAppInfo($event_name, $application_id)
    {
        $application = Application::where("id", $application_id)->first()->load("submits.users")->load("answers")->load("questions");
        return view('admin.app_info')->with(['application' => $application, 'event_name' => $event_name]);
    }

    public function showUserInfo($user_id)
    {
        $user = User::find($user_id);
        return view('admin.user')->with(['user' => $user]);
    }

    public function showUsers()
    {
        $users = User::all();
        return view('admin.users')->with(['users' => $users]);
    }

    public function showEditUserForm($user_id)
    {
        $user = User::find($user_id);
        return view('admin.edit_user')->with(['user' => $user]);
    }

    public function editUser($user_id, Request $request)
    {
        $this->validator($request->all(), $user_id)->validate();

        $user = User::find($user_id);

        $user->update([
            'login' => $request->login,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'role' => $request->role,
        ]);
    }

    public function doDeleteUser($user_id, Request $request)
    {
        UserHandler::deleteUser($user_id);
        return redirect()->route('users');
    }

    public function doDeleteTeam($team_id, Request $request)
    {
        TeamHandler::deleteTeam($team_id);
        return redirect()->route('show_event_info', $request->get('event_name'));
    }

    public function showUploadMaterialsPage(string $event_name)
    {
        $event = Event::where('event_name', $event_name)->first();
        $event_materials_dir = "events/{$event->event_dir_name}/materials";
        $event_materials_dir_for_ru = "events/{$event->event_dir_name}/materials/ru";
        $event_materials_dir_for_en = "events/{$event->event_dir_name}/materials/en";
        $common_materials = Storage::files($event_materials_dir);
        $ru_materials = Storage::files($event_materials_dir_for_ru);
        $en_materials = Storage::files($event_materials_dir_for_en);

        return view('events.upload_materials', [
            'common_materials' => $common_materials,
            'ru_materials' => $ru_materials,
            'en_materials' => $en_materials,
            'event_name' => $event_name,
        ]);
    }

    public function uploadMaterials(Request $request, string $event_name, string $locale = "")
    {
        $file = $request->allFiles()['file'];
        $event = Event::where("event_name", $event_name)->first();
        $filename = trim(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "." . $file->getClientOriginalExtension());
        try {
            $uploaded_file = Storage::putFileAs(
                "events/{$event->event_dir_name}/materials/{$locale}",
                $file,
                $filename
            );
        } catch (\Exception $ob) {
            return response()->json(['errors' => $ob->getMessage()], 422);
        }
        return response()->json(['$uploaded_file' => str_replace("//", "/", $uploaded_file)], 200);
    }


    public function deleteMaterials(Request $request)
    {
        // dump($request->file_path);
        try {
            Storage::delete($request->file_path);
        } catch (\Exception $ob) {
            return response()->json(['errors' => $ob->getMessage()], 422);
        }
        return response()->json(['$success' => "success"], 200);
    }

    public function doDeleteSubmit($submit_id)
    {
        $submit = SubmitHandler::deleteSubmit($submit_id);
        return redirect()->route('show_app_answers', $submit->application_id);
    }

    public function doUnbindUserFromSubmit($user_id, $submit_id)
    {
        $submit = SubmitHandler::unbindUserFromSubmit($user_id, $submit_id);
        return redirect()->route('show_app_answers', $submit->application_id);
    }

    protected function validator(array $data, $user_id)
    {
        return Validator::make($data, [
            'login' => ['required', 'string', 'max:255', 'min:2', 'unique:users,login,' . $user_id],
        ]);
    }

    protected function validator_password(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:1', 'confirmed']
        ]);
    }

    public function doShowApplicationForm(int $submit_id, string $locale = 'ru')
    {
        $submit = Submit::find($submit_id)->load(["users", "application.event"]);
        // dd($submit);
        $user = $submit->users()->first();
        $application = $submit->application;
        $event = $submit->application->event;
        // dd($application->id);
        return ApplicationHandler::showApplicationForm($event->event_name, $application->id, $user->id, 'admin.edit_form', $locale);
    }

    public function showAppAnswers(int $application_id)
    {
        $submits = Submit::with("users")->where("application_id", $application_id)->get();
        $questions = Question::where("application_id", $application_id)->whereNotNull("name")->orderBy("position")->get();
        $application = Application::with("event")->where("id", $application_id)->first();
        // dd($questions);
        $answers = AnswerHandler::getAnswersForApp($application_id)->sortBy('question.position');
        $answers = $answers->groupBy('submit_id');
        return view('admin.app_answers')->with(["answers" => $answers, "submits" => $submits, "questions" => $questions, "application" => $application]);
    }
}

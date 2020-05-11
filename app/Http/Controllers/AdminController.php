<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\User;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Src\ApplicationHandlers\ValidationHandler;
use App\Models\Application\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    public function showAppInfo($event_name, $app_id)
    {
        $application = Application::where("id", $app_id)->first()->load("submits.users")->load("answers")->load("questions");
        //        $application = Application::find($app_id)->first()->load("submits.users");
        //        dd($application);
        return view('admin.app_info')->with(['application' => $application, 'event_name' => $event_name]);
    }

    public function editApplicationDataForUser(int $application_id, int $user_id, Request $request)
    {
        Auth::onceUsingId($user_id);

        $validator = ValidationHandler::validateAppData($application_id, $this->request_post, $this->request_files);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        session(['locale' => app()->getLocale()]);
        $this->application = Application::find($application_id)->load('event');

        $this->event = $this->application->event;
        // dd(Auth::user());
        $appHandler = new ApplicationHandler($application_id, $request, Auth::user(), $this->event);
        return  $appHandler->editForUserApplicationSubmit();
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

    public function deleteUser($user_id, Request $request)
    {
        $directory = Storage::getAdapter()->getPathPrefix() . "events";
        // dd($user_id);
        function getUserDirs($dir, $search_dir)
        {
            $subDir = array();

            $dirs = [];
            $directories = array_filter(glob($dir), 'is_dir');
            $subDir = array_merge($subDir, $directories);
            foreach ($directories as $directory) {
                if (preg_match($search_dir, $directory)) {
                    // dump($directory);

                    exec("rm -rf " . $directory . "/*");
                    // $dirs[] = $directory;
                }
                $subDir = array_merge($subDir, getUserDirs($directory . '/*', $search_dir));
            }
            // dump($subDir);
            return $dirs;
        }

        // $user = User::find($user_id)->delete();
        /*         $sb = getUserDirs($directory, "/users_data\/{$user_id}$/");
        dd($sb); */
        // dd(Storage::getAdapter()->getPathPrefix());
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
        $dirs = array_filter(glob($directory), 'is_dir');
        /*   print_r($dirs);
        $dir = new \DirectoryIterator($directory);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                echo $fileinfo->getFilename() . '<br>';
            }
        }
        dd(3); */
        $it->rewind();
        while ($it->valid()) {

            if (!$it->isDot()) {
                /*       echo 'SubPathName: ' . $it->getSubPathName() . "<br>";
                echo 'SubPath:     ' . $it->getSubPath() . "<br>";
                echo 'Key:         ' . $it->key() . "<br>"; */

                if (strpos($it->key(), "users_data/{$user_id}/")) {
                }
            }

            $it->next();
        }
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


    public function doShowApplicationFormForUser(string $event_name, int $application_id, $user_id)
    {
        return ApplicationHandler::showApplicationFormForEdit($event_name, $application_id, $user_id);
    }

    public function doShowApplicationFormForSubmit(string $event_name, int $application_id, $submit_id)
    {
        $user = Submit::find($submit_id)->users()->first();
        // $user=User::first()
        // dd($user);
        return ApplicationHandler::showApplicationFormForEdit($event_name, $application_id, $user->id);
    }
}

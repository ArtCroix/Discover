<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Application\Submit;
use App\Src\EventHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Src\ApplicationHelpers\ApplicationHelper;
use App\Src\ApplicationHelpers\TeamHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function eventStatus(string $event_name, string $locale = 'ru')
    {
        $user_id = \Auth::user()->id;
        $team = TeamHelper::getTeamForEvent($event_name, $user_id);
        $eventApplications = ApplicationHelper::getEventApplicationsForUser($event_name, Auth::user()->id, $locale);
        return view('events.event', [
            'event' => Event::where('event_name', request()->event_name)->first(),
            'eventApplications' => $eventApplications,
            'team' => $team
        ]);
    }

    public function showMaterialsPage(string $event_name, string $locale = 'ru')
    {
        $event = Event::where('event_name', $event_name)->first();
        $event_materials_dir = "events/{$event->event_dir_name}/materials";
        $event_materials_dir_for_locale = "events/{$event->event_dir_name}/materials/{$locale}";
        $materials = [];
        $common_materials = Storage::files($event_materials_dir);
        $locale_materials = Storage::files($event_materials_dir_for_locale);
        $materials = [...$common_materials, ...$locale_materials];
        $eventApplications = ApplicationHelper::getEventApplicationsForUser($event_name, Auth::user()->id, $locale);
        return view('events.materials', [
            'eventApplications' => $eventApplications,
            'materials' => $materials
        ]);
    }

    public function showEventCreateForm()
    {
        return view('events.create_event');
    }

    public function showEventEditForm($event_id)
    {
        $event = Event::find($event_id);
        return view('events.edit_event')->with(['event' => $event]);
    }

    public function doCreateEvent(Request $request)
    {
        $this->validatorForCreate($request->all())->validate();
        $event = EventHandler::createEvent($request->all());
        EventHandler::copyApplicationsToNewEvent($event->id);
    }

    public function doEditEvent($event_id, Request $request)
    {
        $this->validatorForEdit($request->all(), $event_id)->validate();
        EventHandler::editEvent($request->all(), $event_id);
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
    }
}

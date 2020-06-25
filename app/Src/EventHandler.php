<?php

namespace App\Src;

use App\Models\Application\Application;
use App\Models\Application\Question;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventHandler
{

    public static function createEvent($data)
    {
        $title = self::createTitle($data);
        self::makeEventDir($data);
        return Event::create([
            'event_name' => $data['event_name'],
            'event_dir_name' => $data['event_name'],
            'title' => $title,
            'active' => 1,
            'description' => $data['description'],
            'admin_only' => 1,
            'price' => $data['string_price'],
        ]);
    }

    public static function getMaterials($event_name, $locale)
    {
        $event = Event::where('event_name', $event_name)->first();
        $event_materials_dir = "events/{$event->event_dir_name}/materials";
        $event_materials_dir_for_locale = "events/{$event->event_dir_name}/materials/{$locale}";
        $materials = [];
        $common_materials = Storage::files($event_materials_dir);
        $locale_materials = Storage::files($event_materials_dir_for_locale);
        $materials = [...$common_materials, ...$locale_materials];
        return $materials;
    }

    public static function editEvent($data, $event_id)
    {
        $event = Event::find($event_id);
        $title = self::createTitle($data);
        $event->update([
            'event_name' => $data['event_name'],
            'event_dir_name' => $data['event_name'],
            'title' => $title,
            'active' => $data['active'],
            'admin_only' => $data['admin_only'],
            'description' => $data['description'],
            'price' => $data['string_price'],
        ]);
    }

    public static function makeEventDir($data)
    {
        Storage::makeDirectory("events/{$data['event_name']}");
        Storage::makeDirectory("events/{$data['event_name']}/applications");
        Storage::makeDirectory("events/{$data['event_name']}/materials/ru");
        Storage::makeDirectory("events/{$data['event_name']}/materials/en");
    }

    public static function copyApplicationsToNewEvent(int $event_id)
    {
        $application_types = ["team_registration", "invitation", "passport_data", "thematic", "contract", "offerta"];

        foreach ($application_types as $type) {
            $application = Application::where("event_id", 1)->where("type", $type)->first()->load("questions");
            $newApplication = $application->replicate();
            $newApplication->event_id = $event_id;

            $questions = $newApplication->questions;
            $newApplication->save();

            foreach ($questions as $question) {
                unset($question->id);
                $question->application_id = $newApplication->id;
            }
            $questions = $questions->toArray();
            $newApplication->questions()->createMany($questions);
        }
    }

    public static function createTitle($data)
    {
        return json_encode(["ru" => $data['full_name_ru'], "en" => $data['full_name_en']]);
    }
}

<?php

namespace App\Src;


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
            'active' => 0,
            'admin_only' => 1,
            'price' => $data['price'],
        ]);
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
            'price' => $data['price'],
        ]);
    }

    public static function makeEventDir($data)
    {
        Storage::makeDirectory("events/{$data['event_name']}");
        Storage::makeDirectory("events/{$data['event_name']}/applications");
        Storage::makeDirectory("events/{$data['event_name']}/materials/ru");
        Storage::makeDirectory("events/{$data['event_name']}/materials/en");
    }

    public static function createTitle($data)
    {
        return json_encode(["ru" => $data['full_name_ru'], "en" => $data['full_name_en']]);
    }
}

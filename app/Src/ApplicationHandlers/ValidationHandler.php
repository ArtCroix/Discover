<?php

namespace App\Src\ApplicationHandlers;

use App\Application\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ValidationHandler
{
    public static $application_id;
    public static $request_all;
    public static $request_files;

    public static function validateAppData(int $application_id, array $request_all, array $request_files = [])
    {
        self::$application_id = $application_id;
        self::$request_all = $request_all;
        self::$request_files = $request_files;

        $arrayForValidation = self::prepareRequestForValidation();

        $rules = self::getRules();

        return Validator::make($arrayForValidation, $rules);
    }

    public static function prepareRequestForValidation()
    {
        self::$request_files = self::addMetaDataToFileObjects(self::$request_files,
            [
                'application_id' => self::$application_id,
                'user_id' => Auth::user()->id,
            ]);

        $arrayForValidation = [];

        foreach (self::$request_all as $key => $value) {
            $arrayForValidation[substr(strstr($key, '#'), 1)] = $value;
        }

        return $arrayForValidation;
    }

    public static function addMetaDataToFileObjects(array $request_files, array $meta_data = [])
    {
        if (count($request_files)) {
            foreach ($request_files as $key => $value) {
                foreach ($value as $file) {
                    $file->additional_meta_data = array_merge($meta_data, ['question_id' => strtok($key, "#")]);
                    break;
                }
            }
        }
        return $request_files;
    }

    public static function getRules()
    {
        return Question::select('name', 'rule')
            ->where('application_id', self::$application_id)
            ->whereNotNull('rule')
            ->get()
            ->pluck('rule', 'name')
            ->toArray();
    }
}

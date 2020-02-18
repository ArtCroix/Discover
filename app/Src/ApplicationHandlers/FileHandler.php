<?php

namespace App\Src\ApplicationHandlers;

use App\Application\Answer;
use Illuminate\Support\Facades\Storage;

class FileHandler
{
    protected $store_path;

    public function __construct($store_path)
    {
        $this->store_path = $store_path;
    }

    public static function getListOfUploadedFiles($question_id, $submit_id)
    {
        $listOfUploadedFiles = Answer::where('submit_id', $submit_id)->where('question_id', $question_id)->first() ?: new Answer();
        // dd($listOfUploadedFiles);
        return json_decode($listOfUploadedFiles->value) ?: [];
    }

    public static function uploadFiles($store_path, $submit_id, $request_files)
    {
        // dd($request_files);
        $files_pathes = [];
        if (count($request_files) > 0) {
            foreach ($request_files as $field_name => $value) {
                $pathes = [];
                foreach ($value as $file) {

                    $filename = trim(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $file->getClientOriginalExtension());

                    $pathes[] = Storage::putFileAs(
                        $store_path,
                        $file,
                        $filename
                    );
                }

                $pathes = array_merge(self::getListOfUploadedFiles(strtok($field_name, '#'), $submit_id), $pathes);
                // dd($pathes);
                $files_pathes[$field_name] = $pathes;
            }

        }
        // dd($files_pathes);
        return $files_pathes;
    }
}

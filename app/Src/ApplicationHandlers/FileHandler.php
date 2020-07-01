<?php

namespace App\Src\ApplicationHandlers;

use App\Models\Application\Answer;
use Illuminate\Support\Facades\Storage;
use File;
use ZipArchive;

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
            self::archiveFiles($store_path);
        }
        // 
        // dump($files_pathes);
        return $files_pathes;
    }

    public static function archiveFiles($store_path)
    {
        $store_path = storage_path("app/public/" . $store_path);

        //Удалить zip-архив
        array_map('unlink', glob($store_path . "/*.zip"));

        $zip = new ZipArchive();
        $zip_name = \Auth::user()->id . ".zip";
        // $zip_name = \Auth::user()->lastname . "_" . \Auth::user()->firstname . "_" . \Auth::user()->middlename . ".zip";
        $zip->open($store_path . "/" . $zip_name, \ZIPARCHIVE::CREATE);
        $files = File::files($store_path);
        foreach ($files as $file) {
            $relativeNameInZipFile = basename($file);
            if (strpos($relativeNameInZipFile, ".zip") === false) {
                $zip->addFile($file, $relativeNameInZipFile);
            }
        }
        $zip->close();
    }
}

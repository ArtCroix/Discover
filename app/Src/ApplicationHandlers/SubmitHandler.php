<?php

namespace App\Src\ApplicationHandlers;

use App\Models\Application\Answer;
use App\Models\Application\Submit;
use App\User;
use App\Src\UserHandler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SubmitHandler
{
    public function __construct($application_id, $user_id, $submit_id)
    {
    }

    public static function getSubmit($user_id, $application_id)
    {
        return \DB::table('questions')
            ->leftJoin('answers', 'answers.question_id', '=', 'questions.id')
            ->leftJoin('submits', function ($join) use ($user_id) {
                return $join->on('submits.id', '=', 'answers.submit_id');
            })->where('submits.user_id', '=', $user_id)
            ->where('questions.application_id', '=', $application_id)
            ->select(
                'questions.id as question_id',
                'questions.application_id',
                'questions.name',
                'questions.value',
                'questions.presentation',
                'questions.presentation_en',
                'questions.type',
                'questions.label',
                'questions.label_en',
                'answers.value as answer',
                'answers.submit_id',
            )
            ->orderBy('position')
            ->get();
    }

    public static function addSubmit(int $application_id, User $user): Submit
    {
        $submit = Submit::with('users')->where('application_id', $application_id)->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();
        // dd($submit);
        if (!$submit) {
            $submit = Submit::create(
                [
                    // 'user_id' => $user->id,
                    'application_id' => $application_id,
                ]
            );
            $submit->users()->syncWithoutDetaching([$user->id]);
        }

        return $submit;
    }

    public static function deleteFileFromApplicationSubmit(Request $request, $store_path)
    {
        $files = FileHandler::getListOfUploadedFiles($request->question_id, $request->submit_id);

        $files = array_values(array_filter($files, function ($v) use ($request) {
            return $v != $request->file_path;
        })) ?: null;
        Answer::where('submit_id', $request->submit_id)
            ->where('question_id', $request->question_id)
            ->update(['value' => $files]);
        Storage::delete($request->file_path);
        FileHandler::archiveFiles($store_path);
    }

    public static function deleteSubmit($submit_id)
    {
        $submit = Submit::find($submit_id)->load("users");
        foreach ($submit->users as $user) {
            UserHandler::deleteUserDirs($user->id);
        }
        $submit->delete();
        return $submit;
    }

    public static function unbindUserFromSubmit($user_id, $submit_id)
    {
        $submit = Submit::find($submit_id)->load("users");
        foreach ($submit->users as $user) {
            UserHandler::deleteUserDirs($user->id);
        }
        $submit->users()->detach([$user_id]);
        return $submit;
    }
}

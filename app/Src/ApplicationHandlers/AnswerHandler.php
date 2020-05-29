<?php

namespace App\Src\ApplicationHandlers;

use App\Models\Application\Answer;
use App\Models\Application\Submit;
use Illuminate\Support\Facades\DB;

class AnswerHandler
{
    public static function addAnswers(Submit $submit, array $request_post)
    {
        $answers = [];

        foreach ($request_post as $key => $value) {
            if (strpos($key, '#')) {
                $value = is_array($value) ? json_encode($value) : $value;
                array_push($answers, ['submit_id' => $submit->id, 'application_id' => $submit->application_id, 'value' => $value, 'question_id' => strtok($key, '#')]);
            }
        }
        // dd($answers);
        DB::transaction(function () use ($answers) {

            $answers_length = count($answers);

            for ($i = 0; $i < $answers_length; $i++) {
                Answer::updateOrCreate(
                    ['question_id' => $answers[$i]['question_id'], 'submit_id' => $answers[$i]['submit_id']],
                    $answers[$i]
                );
            }
        });
    }

    public static function getAnswersForApp($application_id)
    {
        /*    $answers = Answer::with(["question" => function ($query) {
            $query->orderBy('position');
        }])->where("application_id", $application_id)->get();
        dd($answers); */
        $answers = Answer::where("application_id", $application_id)->get()->load("question");
        return $answers;
    }

    public static function getAnswersForSubmit($submit_id)
    {
        $answers = Answer::where("submit_id", $submit_id)->get()->load("question");
        return $answers;
    }
}

<?php

namespace App\Src\ApplicationHandlers;

use App\Application\Answer;
use App\Application\Submit;
use Illuminate\Support\Facades\DB;

class AnswerHandler
{
    public static function addAnswers(Submit $submit, array $request_post)
    {
        $answers = [];
        // dd($request_post);
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
}

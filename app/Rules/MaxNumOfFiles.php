<?php

namespace App\Rules;

use App\Models\Application\Answer;
use App\Models\Application\Submit;
use App\Src\FileHandler;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class MaxNumOfFiles implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return false;
    }

    public function validate($attribute, $value, $parameters, $validator)
    {
        // dd($value);

        try {
            $currentlyUploadedFiles = Submit::where('user_id', $value[0]->additional_meta_data['user_id'])->where('application_id', $value[0]->additional_meta_data['application_id'])->firstOrFail()->answers()->where('question_id', $value[0]->additional_meta_data['question_id'])->firstOrFail();
            $currentlyUploadedFilesArray = json_decode($currentlyUploadedFiles->value) ?: [];
        } catch (ModelNotFoundException $er) {
            $currentlyUploadedFilesArray = [];
        }
        // dd($currentlyUploadedFilesArray);
        return count($value) + count($currentlyUploadedFilesArray) <= $parameters[0];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Too much files';
    }
}

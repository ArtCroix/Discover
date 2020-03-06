<?php

namespace App\Rules;

use App\Models\Application\Answer;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class MinFilesInDir implements Rule
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
        $currentFilesCount = Storage::files($value[0]->store_path);
        // dd($currentFilesCount);
        return count($value) + count($currentFilesCount) >= $parameters[0];
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

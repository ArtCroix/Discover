<?php

namespace App\Http\Requests;

use App\Application\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreApplicationData extends FormRequest
{

    protected $rules_array;

    public function __construct()
    {
        /*       $this->rules_array = [
    'rules' => [],
    'validation_messages' => [],
    ]; */
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->rules_array = DB::table('rules')
            ->join('questions', 'questions.name', '=', 'rules.post_name')
            ->where('questions.application_id', request()->route()->parameter('app_id'))
            ->select(
                DB::raw('rules.post_name as field'),
                'rule'
            )
            ->get()
            ->pluck('rule', 'field')
            ->toArray();
        $this->merge($this->rules_array);
        // dd($this->request->toArray());

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules_array;
        /*  return [
    "firstname_1" => "required|min:255",
    "user_email_1" => "required",
    "team_name" => "required",
    "country" => "required",
    "lastname_1" => "required_with:firstname_1",
    ]; */
    }
}

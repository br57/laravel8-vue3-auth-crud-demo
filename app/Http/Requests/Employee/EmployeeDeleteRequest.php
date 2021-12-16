<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class EmployeeDeleteRequest extends FormRequest
{
    /**
     * Force response json type when validation fails
     * @var bool
     */
    protected $forceJsonResponse = true;

    /**
     * Determine if the employee is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid' => 'required|uuid|exists:employees,uuid',
        ];
    }

    /**
     * Modify the input values
     *
     * @return void
     */
    protected function prepareForValidation() 
    {
        //Get Request path
        $path = \Request::path();

        $path_array = explode("/", $path);

        //UUID is LAST segement in URL
        $input['uuid'] = $path_array[array_key_last($path_array)];

        //Set UUID for Validation
        $this->replace($input);
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'error' => true,
            'success' => false,
            'errors' => $validator->errors()
        ]);            
        
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}

<?php

namespace App\Http\Requests\Employee;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class EmployeePatchRequest extends FormRequest
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
     * Modify the input values
     *
     * @return void
     */
    protected function prepareForValidation() 
    {
        function _camelTo_underscore($string, $us = "_") {
            return strtolower(preg_replace(
                // '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
                '/(?<=[a-z])(?=[A-Z])/', $us, $string));
        }

        foreach(Request::input() as $key => $value) {
            $underscore_key = _camelTo_underscore($key);
            $input[$underscore_key] = $value;
        }

        $this->replace($input);
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
            'first_name' => 'required|string|max:24',
            'last_name' => 'required|string|max:24',
            'email' => [
                'filled',
                'email',
                Rule::unique('employees')->ignore($this->uuid, 'uuid')
            ],
            'phone' => 'nullable|string',
            'company_uuid' => 'nullable|uuid|exist:companies,uuid',
            'status' => 'nullable|in:Active,InActive',
        ];
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

<?php

namespace App\Http\Requests\Modules\User;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class PatchRequest extends FormRequest
{
    /**
     * Force response json type when validation fails
     * @var bool
     */
    protected $forceJsonResponse = true;

    /**
     * Determine if the company is authorized to make this request.
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
        $additionalValidations = [
            'email' => [
                'filled',
                'email',
                Rule::unique('users')->ignore($this->uuid, 'uuid')
            ]
        ];
        return \App\Models\User::uuidValidations($additionalValidations);
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

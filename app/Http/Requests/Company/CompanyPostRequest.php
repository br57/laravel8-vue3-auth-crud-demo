<?php

namespace App\Http\Requests\Company;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CompanyPostRequest extends FormRequest
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
        function _camelToUnderscore($string, $us = "_") {
            return strtolower(preg_replace(
                // '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
                '/(?<=[a-z])(?=[A-Z])/', $us, $string));
        }

        foreach(Request::input() as $key => $value) {
            $underscore_key = _camelToUnderscore($key);
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
            'name' => 'filled|string|max:24',
            'email' => 'filled|email|unique:companies,email',
            'logo' => 'nullable|string',
            'website' => 'nullable|string',
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

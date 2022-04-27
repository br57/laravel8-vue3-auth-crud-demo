<?php

namespace App\Http\Requests\Modules\Company;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class PatchRequest extends FormRequest
{
    protected $forceJsonResponse = true;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation() 
    {
        function _camelTo_underscore($string, $us = "_") {
            return strtolower(preg_replace(
                '/(?<=[a-z])(?=[A-Z])/', $us, $string));
        }
        foreach(Request::input() as $key => $value) {
            $underscore_key = _camelTo_underscore($key);
            $input[$underscore_key] = $value;
        }
        $this->replace($input);
    }

    public function rules()
    {
        $additionalValidations = [
            'email' => [
                'filled',
                'email',
                Rule::unique('companies')->ignore($this->uuid, 'uuid')
            ]
        ];
        return \App\Models\Company::uuidValidations($additionalValidations);
    }

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

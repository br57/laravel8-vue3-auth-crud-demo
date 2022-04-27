<?php

namespace App\Http\Requests\Modules\Company;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PostRequest extends FormRequest
{
    protected $forceJsonResponse = true;

    public function authorize(){
        return true;
    }

    protected function prepareForValidation(){
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

    public function rules()
    {
        return \App\Models\Company::postValidations();
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

<?php

namespace App\Traits;

trait modelHelper {
    public static $_model_validation = [];

    public function postValidations($special = []){
        $all_validations = self::_allValidations();
        if(empty($all_validations)) return [];
        self::$_model_validation = $all_validations->post;
        if(empty($special)){
            return self::$_model_validation;
        }
        return collect(self::$_model_validation)->merge($special)->all();
    }

    public function patchValidations($special = []){
        $all_validations = self::_allValidations();
        if(empty($all_validations)) return [];
        self::$_model_validation = $all_validations->patch;
        if(empty($special)){
            return self::$_model_validation;
        }
        return collect(self::$_model_validation)->merge($special)->all();
    }

    public function uuidValidations($special= []){
        $all_validations = self::_allValidations();
        if(empty($all_validations)) return [];
        self::$_model_validation = $all_validations->uuid;
        if(empty($special)){
            return self::$_model_validation;
        }
        return collect(self::$_model_validation)->merge($special)->all();
    }
    
    public function _allValidations(){
        return [];
    }
}
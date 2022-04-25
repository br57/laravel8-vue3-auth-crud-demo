<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

if (!function_exists('getCacheData')) {
    function getCacheData($modelName = null, $cacheName = null) {
        if(!is_null($modelName)){

            $modal = Str::ucfirst(Str::of($modelName)->trim()->lower());
            $namespacedModel = '\\App\\Models\\'.$modal;
            $modelTable = $cacheName;
            
            if(is_null($modelTable)){
                $modelClass = new $namespacedModel();
                $modelTable = $modelClass->getTable();
            }
            return Cache::get($modelTable, function() use($modelTable, $namespacedModel) {
                return Cache::remember($modelTable, 2629800, function () use($modelTable, $namespacedModel) {
                    return $namespacedModel::get();
                });
            });
        }
        return false;
    }
}

if (!function_exists('refreshCacheData')) {
    function refreshCacheData($modelName = null, $cacheName = null) {
        if(!is_null($modelName)){

            $modelTable = $cacheName;
            
            if(is_null($modelTable)){
                $modal = Str::ucfirst(Str::of($modelName)->trim()->lower());
                $namespacedModel = '\\App\\Models\\'.$modal;
                $modelClass = new $namespacedModel();
                $modelTable = $modelClass->getTable();
            }
            Cache::forget($modelTable);
            return getCacheData($modelName, $cacheName);
        }
        return false;
    }
}
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
            return $namespacedModel::get();
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


if (!function_exists('makeSlug')) {
    function makeSlug($string = null, $modelName = null, $self_id_or_uuid = null, $slug_labels = []) {

        $slug = Str::slug(Str::of($string)->trim(), '-');

        if(is_null($slug)) return null;
        
        if(!is_null($modelName)){

            if(!isset($slug_labels['db_key'])) $slug_labels['db_key'] = 'uuid';
            if(!isset($slug_labels['slug'])) $slug_labels['slug'] = 'slug';
            
            $modal = Str::ucfirst(Str::of($modelName)->trim()->lower());
            $namespacedModel = '\\App\\Models\\'.$modal;
            
            $check = null;
            if(!is_null($self_id_or_uuid)){
                $check = $namespacedModel::where($slug_labels['slug'], $slug)->where($slug_labels['db_key'], '!=' , $self_id_or_uuid)->first();
            }else{
                $check = $namespacedModel::firstWhere($slug_labels['slug'], $slug);
            }

            if(!is_null($check)){
                $newSlug = $slug."-".rand(1,50);
                return $this->makeSlug($newSlug, $modelName, $self_id_or_uuid, $slug_labels);
            }
        }
        return $slug;
    }
}


if (!function_exists('getIdByUuid')) {
    function getIdByUuid($uuid = null, $modelName = null, $db_data = []) {

        if(!is_null($modelName) && !is_null($uuid)){
            $modal = Str::ucfirst(Str::of($modelName)->trim()->lower());
            $namespacedModel = '\\App\\Models\\'.$modal;
            $data = $namespacedModel::firstWhere('uuid', $uuid);
            if(!is_null($data)){
                if(!is_null($data->getKey())){
                    return $data->getKey();
                }
            }
        }
        return null;
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Employee\EmployeeResource;


class CommonController extends Controller
{
    /**
     *  Get Common Data
     * 
     */
    public function getBasicAuthData()
    {
        $users      =   getCacheData('user');
        $companies  =   getCacheData('company');
        $employees  =   getCacheData('employee');
        
        return response()->json([
            'common_data' => [
                'users'         =>  UserResource::collection($users),
                'companies'     =>  CompanyResource::collection($companies),
                'employees'     =>  EmployeeResource::collection($employees),
            ],
            'success'           => true,
        ]);
    }
}

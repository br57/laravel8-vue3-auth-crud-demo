<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Modules\UserResource;
use App\Http\Resources\Modules\CompanyResource;
use App\Http\Resources\Modules\EmployeeResource;
use App\Http\Resources\Common\StatusResource;


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
        $statuses   =   getCacheData('status');
        
        return response()->json([
            'common_data' => json_encode([
                'users'         =>  UserResource::collection($users),
                'companies'     =>  CompanyResource::collection($companies),
                'statuses'      =>  StatusResource::collection($statuses),
                'employees'     =>  EmployeeResource::collection($employees),
            ]),
            'success'           => true,
        ]);
    }
}

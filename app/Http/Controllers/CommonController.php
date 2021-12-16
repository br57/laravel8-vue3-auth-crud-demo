<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Employee\EmployeeResource;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    /**
     *  Get Common Data
     * 
     */
    public function getBasicAuthData()
    {
        $users = Cache::get('users', function(){
            return Cache::remember("users", 2629800, function () {
                return User::all();
            });
        });

        $companies = Cache::get('companies', function(){
            return Cache::remember("companies", 2629800, function () {
                return Company::all();
            });
        });

        $employees = Cache::get('employees', function(){
            return Cache::remember("employees", 2629800, function () {
                return Company::all();
            });
        });

        return response()->json([
            'common_data' => [
                'users'                     => UserResource::collection($users),
                'companies'                 => CompanyResource::collection($companies),
                'employees'                 => EmployeeResource::collection($employees),
            ],
            'success'                   => true,
        ]);
    }
}

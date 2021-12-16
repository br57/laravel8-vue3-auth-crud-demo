<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Employee\EmployeeGetAllRequest;
use App\Http\Requests\Employee\EmployeeGetByIdRequest;
use App\Http\Requests\Employee\EmployeePostRequest;
use App\Http\Requests\Employee\EmployeePatchRequest;
use App\Http\Requests\Employee\EmployeeDeleteRequest;

use App\Models\Employee;
use App\Models\Company;
use App\Http\Resources\Employee\EmployeeResource;

use Illuminate\Support\Facades\Cache;

class EmployeeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Employee\EmployeeGetAllRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeeGetAllRequest $request)
    {
        $employees = Cache::get('employees', function(){
            return Cache::remember("employees", 2629800, function () {
                return Company::all();
            });
        });
        
        return response()->json([
            'employees' => EmployeeResource::collection($employees)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Employee\EmployeePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeePostRequest $request)
    {
        $employee = new Employee;
        $employee->fill($request->validated());
        if($request->has('company_uuid')){
            $company = Company::where('uuid', $request->company_uuid)->get()->first();
            $employee->company_id = $company->id ?? 1;
        }
        $employee->save();
        Cache::forget("employees");
        return response()->json([
            "success" => true,
            "employee" => new EmployeeResource($employee)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\Employee\EmployeeGetByIdRequest $request
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeGetByIdRequest $request)
    {
        $employee = new EmployeeResource(Employee::where('uuid', $request->uuid)->get()->first());

        return response()->json([
            'success' => true,
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Employee\EmployeePatchRequest $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeePatchRequest $request, $uuid)
    {
        $update = $request->validated();
        unset($update['uuid']);
        unset($update['_method']);
        if($request->filled('company_uuid')){
            $update['company_id'] = null;
            $company = Company::where('uuid', $request->company_uuid)->get()->first();
            $update['company_id'] = $company->id;
            unset($update['company_uuid']);
        }
        Employee::where('uuid', $uuid)->update($update);
        Cache::forget("employees");
        return response()->json([
            'success' => true,
            'employee' => new EmployeeResource(Employee::where('uuid', $uuid)->get()->first())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Employee\EmployeeDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeDeleteRequest  $request)
    {
        $success = Employee::where('uuid', $request->uuid)->delete();
        Cache::forget("employees");
        return response()->json([
            'success' => $success
        ]);
    }
}

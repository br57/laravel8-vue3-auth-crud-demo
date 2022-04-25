<?php

namespace App\Http\Controllers\Api\Modules;

use App\Http\Controllers\Controller;

use App\Http\Requests\Modules\Employee\GetAllRequest;
use App\Http\Requests\Modules\Employee\GetByIdRequest;
use App\Http\Requests\Modules\Employee\PostRequest;
use App\Http\Requests\Modules\Employee\PatchRequest;
use App\Http\Requests\Modules\Employee\DeleteRequest;

use App\Models\Employee as modelClass;
use App\Http\Resources\Modules\EmployeeResource as modelResource;

class EmployeeController extends Controller
{
    public function index(getAllReq $request)
    {
        $employees = getCacheData('employee');
        return response()->json([
            'employees' => modelResource::collection($employees)
        ]);
    }

    public function store(PostRequest $request)
    {
        $employee = new modelClass;
        $employee->fill($request->validated());
        if($request->has('company_uuid')){
            $employee->company_id = getIdByUuid($request->company_uuid, 'company');
        }
        if($request->has('status_uuid')){
            $employee->status_id = getIdByUuid($request->status_uuid, 'status');
        }
        $employee->save();
        $employee = $employee->refresh();

        return response()->json([
            "success" => true,
            "employee" => new modelResource($employee)
        ]);
    }

    public function show(GetByIdRequest $request)
    {
        $employee = new modelResource(modelClass::firstWhere('uuid', $request->uuid));

        return response()->json([
            'success' => true,
            'employee' => $employee
        ]);
    }

    public function update(PatchRequest $request, $uuid)
    {
        $employee = modelClass::firstWhere('uuid', $request->uuid);
        $employee->fill($request->validated());
        if($request->has('company_uuid')){
            $employee->company_id = getIdByUuid($request->company_uuid, 'company');
        }
        if($request->has('status_uuid')){
            $employee->status_id = getIdByUuid($request->status_uuid, 'status');
        }
        $employee->save();
        $employee = $employee->refresh();

        return response()->json([
            'success' => true,
            'employee' => new modelResource($employee)
        ]);
    }

    public function destroy(DeleteRequest  $request)
    {
        $success = modelClass::where('uuid', $request->uuid)->delete();
        
        return response()->json([
            'success' => $success
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\Modules;

use App\Http\Controllers\Controller;

use App\Http\Requests\Modules\Company\GetAllRequest;
use App\Http\Requests\Modules\Company\GetByIdRequest;
use App\Http\Requests\Modules\Company\PostRequest;
use App\Http\Requests\Modules\Company\PatchRequest;
use App\Http\Requests\Modules\Company\DeleteRequest;

use App\Models\Company as modelClass;
use App\Http\Resources\Modules\CompanyResource as modelResource;

class CompanyController extends Controller
{
    public function index(GetAllRequest $request)
    {
        $all_company = getCacheData('company');
        return response()->json([
            'companies' => modelResource::collection($all_company)
        ]);
    }

    public function store(PostRequest $request)
    {
        $company = new modelClass;
        $company->fill($request->validated());
        if($request->has('status_uuid')){
            $company->status_id = getIdByUuid($request->status_uuid, 'status');
        }
        if($request->has('user_uuid')){
            $company->user_id = getIdByUuid($request->user_uuid, 'user');
        }
        $company->save();

        return response()->json([
            "success" => true,
            "company" => new modelResource($company)
        ]);
    }

    public function show(GetByIdRequest $request)
    {
        $company = new modelResource(modelClass::firstWhere('uuid', $request->uuid));

        return response()->json([
            'success' => true,
            'company' => $company
        ]);
    }

    public function update(PatchRequest $request, $uuid)
    {
        $company = modelClass::firstWhere('uuid', $request->uuid);
        $company->fill($request->validated());
        if($request->has('status_uuid')){
            $company->status_id = getIdByUuid($request->status_uuid, 'status');
        }
        if($request->has('user_uuid')){
            $company->user_id = getIdByUuid($request->user_uuid, 'user');
        }
        $company->save();
        $company = $company->refresh();

        return response()->json([
            'success' => true,
            'company' => new modelResource($company)
        ]);
    }

    public function destroy(DeleteRequest $request)
    {
        $success = modelClass::where('uuid', $request->uuid)->delete();
        return response()->json([
            'success' => $success
        ]);
    }
}
